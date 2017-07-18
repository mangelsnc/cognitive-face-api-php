<?php

namespace CognitiveFaceApi\Resource;

class Verification
{
    /**
     * @var bool
     */
    private $isIdentical;

    /**
     * @var float
     */
    private $confidence;

    /**
     * SimilarFace constructor.
     * @param bool $isIdentical
     * @param float $confidence
     */
    public function __construct($isIdentical, $confidence)
    {
        $this->isIdentical = $isIdentical;
        $this->confidence = $confidence;
    }

    /**
     * @return bool
     */
    public function isIdentical()
    {
        return $this->isIdentical;
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
            'isIdentical' => $this->isIdentical,
            'confidence' => $this->confidence
        ];
    }
}