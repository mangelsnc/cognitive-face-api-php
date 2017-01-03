<?php

namespace CognitiveFaceApi\Component;

use CognitiveFaceApi\Client;
use CognitiveFaceApi\Exception\InvalidFaceAttributesException;

class FaceClient
{
    const ALLOWED_FACE_ATTRIBUTES = ['age', 'gender', 'headPose', 'smile', 'facialHair', 'glasses'];

    /**
     * @var Client;
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

    }

    public function detect($url, $returnFaceId = true, $returnFaceLandmarks = false, $returnFaceAttributes = null)
    {
        $uri = 'detect';
        $params = [];

        if ($returnFaceId) {
            $params[] = 'returnFaceId';
        }

        if ($returnFaceLandmarks) {
            $params[] = 'returnFaceLandmarks';
        }

        if (null !== $returnFaceAttributes && !$this->validateFaceAttributes($returnFaceAttributes)) {
            throw new InvalidFaceAttributesException($returnFaceAttributes);
        } else {
            $params[] = ['returnFaceAttributes' => $returnFaceAttributes];
        }
    }

    /**
     * @param array $faceAttributes
     * @return boolean
     */
    private function validateFaceAttributes($faceAttributes)
    {
        $attributes = explode(',', $faceAttributes);

        foreach ($attributes as $attribute) {
            if (!in_array($attribute, self::ALLOWED_FACE_ATTRIBUTES)) {
                return false;
            }
        }

        return true;
    }
}