<?php

namespace CognitiveFaceApi\Resource;

class SimilarFace
{
    /**
     * @var string
     */
    private $faceId;

    /**
     * @var float
     */
    private $confidence;

    /**
     * SimilarFace constructor.
     * @param string $faceId
     * @param float $confidence
     */
    public function __construct($faceId, $confidence)
    {
        $this->faceId = $faceId;
        $this->confidence = $confidence;
    }

    /**
     * @return string
     */
    public function getFaceId()
    {
        return $this->faceId;
    }

    /**
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'faceId' => $this->faceId,
            'confidence' => $this->confidence
        ];
    }
}