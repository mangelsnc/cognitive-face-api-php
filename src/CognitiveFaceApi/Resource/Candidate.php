<?php

namespace CognitiveFaceApi\Resource;

class Candidate
{
    /**
     * @var string
     */
    private $personId;

    /**
     * @var float
     */
    private $confidence;

    /**
     * SimilarFace constructor.
     * @param string $personId
     * @param float $confidence
     */
    public function __construct($personId, $confidence)
    {
        $this->personId = $personId;
        $this->confidence = $confidence;
    }

    /**
     * @return string
     */
    public function getPersonId()
    {
        return $this->personId;
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
            'personId' => $this->personId,
            'confidence' => $this->confidence
        ];
    }
}