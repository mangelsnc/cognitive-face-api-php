<?php

namespace CognitiveFaceApi\Component;

use CognitiveFaceApi\Client;
use CognitiveFaceApi\Exception\InvalidFaceAttributesException;
use CognitiveFaceApi\Exception\InvalidPhotoUrlException;
use CognitiveFaceApi\Factory\FaceFactory;
use CognitiveFaceApi\Resource\Face;
use CognitiveFaceApi\Resource\FaceAttributes;

class FaceClient
{
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
     * @throws InvalidFaceAttributesException
     * @throws InvalidPhotoUrlException
     */
    public function detect($photoUrl, $returnFaceId = true, $returnFaceLandmarks = false, $returnFaceAttributes = null)
    {
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

        return FaceFactory::createFromArray($detectionData[0]);
    }

    /**
     * @param array $faceAttributes
     * @return boolean
     */
    private function validateFaceAttributes($faceAttributes)
    {
        foreach ($faceAttributes as $attribute) {
            if (!in_array($attribute, FaceAttributes::getAllowedFaceAttributes())) {
                return false;
            }
        }

        return true;
    }
}