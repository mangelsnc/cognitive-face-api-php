<?php

namespace CognitiveFaceApi\Component;

use CognitiveFaceApi\Client;
use CognitiveFaceApi\Exception\FaceNotFoundException;
use CognitiveFaceApi\Exception\InvalidConfidenceThresholdException;
use CognitiveFaceApi\Exception\InvalidFaceAttributesException;
use CognitiveFaceApi\Exception\InvalidMatchModeException;
use CognitiveFaceApi\Exception\InvalidNumberOfCandidatesException;
use CognitiveFaceApi\Exception\InvalidPhotoUrlException;
use CognitiveFaceApi\Factory\FaceFactory;
use CognitiveFaceApi\Resource\Candidate;
use CognitiveFaceApi\Resource\Face;
use CognitiveFaceApi\Resource\FaceAttributes;
use CognitiveFaceApi\Resource\FaceList;
use CognitiveFaceApi\Resource\Person;
use CognitiveFaceApi\Resource\PersonGroup;
use CognitiveFaceApi\Resource\SimilarFace;
use CognitiveFaceApi\Resource\Verification;

class FaceManager
{
    const MATCH_PERSON = 'matchPerson';
    const MATCH_FACE = 'matchFace';
    const DEFAULT_SIMILAR_CANDIDATES = 20;
    const MAX_SIMILAR_CANDIDATES = 1000;
    const MIN_SIMILAR_CANDIDATES = 1;
    const DEFAULT_IDENTIFY_CANDIDATES = 1;
    const MAX_IDENTIFY_CANDIDATES = 5;
    const MIN_IDENTIFY_CANDIDATES = 1;
    const MIN_CONFIDENCE_THRESHOLD = 0;
    const MAX_CONFIDENCE_THRESHOLD = 1;

    /**
     * @var Client;
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

    }

    /**
     * @param $photoUrl
     * @param bool $returnFaceId
     * @param bool $returnFaceLandmarks
     * @param array|null $returnFaceAttributes
     * @return Face
     * @throws FaceNotFoundException
     * @throws InvalidFaceAttributesException
     * @throws InvalidPhotoUrlException
     */
    public function detect(
        $photoUrl,
        $returnFaceId = true,
        $returnFaceLandmarks = false,
        $returnFaceAttributes = null
    ): Face {
        $uri = 'detect';
        $params = [];

        if ($returnFaceId) {
            $params['returnFaceId'] = true;
        }

        if ($returnFaceLandmarks) {
            $params['returnFaceLandmarks'] = true;
        }

        if (!filter_var($photoUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidPhotoUrlException();
        }

        if (null !== $returnFaceAttributes && !$this->validateFaceAttributes($returnFaceAttributes)) {
            throw new InvalidFaceAttributesException($returnFaceAttributes);
        } else {
            $params['returnFaceAttributes'] = implode(',', $returnFaceAttributes);
        }

        if (0 < count($params)) {
            $queryString = http_build_query($params);
            $uri = urldecode($uri . '?' . $queryString);
        }

        $detectionData = $this->client->doRequest($uri, 'POST', ['url' => $photoUrl]);

        if (null == $detectionData) {
            throw new FaceNotFoundException();
        }

        return FaceFactory::createFromArray($detectionData[0]);
    }

    /**
     * @param array $faceAttributes
     * @return bool
     */
    private function validateFaceAttributes($faceAttributes): bool
    {
        foreach ($faceAttributes as $attribute) {
            if (!in_array($attribute, FaceAttributes::getAllowedFaceAttributes())) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Face $face
     * @param FaceList $faceList
     * @param int $candidates
     * @param string $matchMode
     * @return array
     * @throws InvalidMatchModeException
     * @throws InvalidNumberOfCandidatesException
     */
    public function findSimilar(
        Face $face,
        FaceList $faceList,
        $candidates = self::DEFAULT_SIMILAR_CANDIDATES,
        $matchMode = self::MATCH_PERSON
    ): array {
        $uri = 'findsimilars';

        $this->checkSimilarCandidatesNumber($candidates);
        $this->checkValidMatchMode($matchMode);

        $similarData = $this->client->doRequest($uri, 'POST', [
            'faceId' => $face->getId(),
            'faceListId' => $faceList->getId(),
            'maxNumOfCandidatesReturned' => $candidates,
            'mode' => $matchMode
        ]);

        $response = [];

        foreach ($similarData as $data) {
            $similar = new SimilarFace($data['persistedFaceId'], $data['confidence']);
            $response[] = $similar;
        }

        return $response;
    }

    /**
     * @param $candidates
     * @throws InvalidNumberOfCandidatesException
     */
    private function checkSimilarCandidatesNumber($candidates)
    {
        if (self::MAX_SIMILAR_CANDIDATES < $candidates) {
            throw new InvalidNumberOfCandidatesException(self::MIN_SIMILAR_CANDIDATES, self::MAX_SIMILAR_CANDIDATES);
        }

        if (self::MIN_SIMILAR_CANDIDATES > $candidates) {
            throw new InvalidNumberOfCandidatesException(self::MIN_SIMILAR_CANDIDATES, self::MAX_SIMILAR_CANDIDATES);
        }
    }

    /**
     * @param $matchMode
     * @throws InvalidMatchModeException
     */
    private function checkValidMatchMode($matchMode)
    {
        if (!$this->isValidMatchMode($matchMode)) {
            throw new InvalidMatchModeException();
        }
    }

    /**
     * @param $matchMode
     * @return bool
     */
    private function isValidMatchMode($matchMode)
    {
        return in_array($matchMode, self::getMatchModes());
    }

    /**
     * @return array
     */
    public static function getMatchModes()
    {
        return [
            self::MATCH_FACE,
            self::MATCH_PERSON
        ];
    }

    /**
     * @param Face $face
     * @param PersonGroup $personGroup
     * @param int $candidates
     * @param float $threshold
     * @return array
     * @throws InvalidConfidenceThresholdException
     * @throws InvalidNumberOfCandidatesException
     */
    public function identify(
        Face $face,
        PersonGroup $personGroup,
        $candidates = self::DEFAULT_IDENTIFY_CANDIDATES,
        $threshold = null
    ): array {
        $uri = 'identify';

        $this->checkIdentifyCandidatesNumber($candidates);
        $this->checkIdentifyConfidenceThreshold($threshold);

        $body = [
            'faceIds' => [$face->getId()],
            'personGroupId' => $personGroup->getId(),
            'maxNumOfCandidatesReturned' => $candidates,
        ];

        if (null !== $threshold) {
            $body['confidenceThreshold'] = $threshold;
        }

        $identifyData = $this->client->doRequest($uri, 'POST', $body);

        $response = [];

        foreach ($identifyData[0]['candidates'] as $data) {
            $candidate = new Candidate($data['personId'], $data['confidence']);
            $response[] = $candidate;
        }

        return $response;
    }

    /**
     * @param $candidates
     * @throws InvalidNumberOfCandidatesException
     */
    private function checkIdentifyCandidatesNumber($candidates)
    {
        if (self::MAX_IDENTIFY_CANDIDATES < $candidates) {
            throw new InvalidNumberOfCandidatesException(self::MIN_IDENTIFY_CANDIDATES, self::MAX_IDENTIFY_CANDIDATES);
        }

        if (self::MIN_IDENTIFY_CANDIDATES > $candidates) {
            throw new InvalidNumberOfCandidatesException(self::MIN_IDENTIFY_CANDIDATES, self::MAX_IDENTIFY_CANDIDATES);
        }
    }

    /**
     * @param $threshold
     * @throws InvalidConfidenceThresholdException
     */
    private function checkIdentifyConfidenceThreshold($threshold)
    {
        if (self::MIN_CONFIDENCE_THRESHOLD > $threshold || self::MAX_CONFIDENCE_THRESHOLD < $threshold) {
            throw new InvalidConfidenceThresholdException(self::MIN_CONFIDENCE_THRESHOLD,
                self::MAX_CONFIDENCE_THRESHOLD);
        }
    }

    /**
     * @param Face $face
     * @param Face $secondFace
     * @return Verification
     */
    public function verifyFaceToFace(Face $face, Face $secondFace): Verification
    {
        $uri = 'verify';

        $body = [
            'faceId1' => $face->getId(),
            'faceId2' => $secondFace->getId()
        ];

        $verifyData = $this->client->doRequest($uri, 'POST', $body);

        $verification = new Verification($verifyData['isIdentical'], $verifyData['confidence']);

        return $verification;
    }

    /**
     * @param Face $face
     * @param Person $person
     * @return Verification
     * @throws InvalidConfidenceThresholdException
     * @throws InvalidNumberOfCandidatesException
     */
    public function verifyFaceToPerson(Face $face, Person $person): Verification
    {
        $uri = 'verify';

        $body = [
            'faceId' => $face->getId(),
            'personGroupId' => $person->getGroup(),
            'personId' => $person->getId()
        ];

        $verifyData = $this->client->doRequest($uri, 'POST', $body);

        $verification = new Verification($verifyData['isIdentical'], $verifyData['confidence']);

        return $verification;
    }
}