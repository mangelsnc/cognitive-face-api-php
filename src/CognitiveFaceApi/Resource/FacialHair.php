<?php

namespace CognitiveFaceApi\Resource;

class FacialHair
{
    /**
     * @var float
     */
    private $moustache;

    /**
     * @var float
     */
    private $beard;

    /**
     * @var float
     */
    private $sideburns;

    public function __construct($moustache, $beard, $sideburns)
    {
        $this->moustache = $moustache;
        $this->beard = $beard;
        $this->sideburns = $sideburns;
    }

    /**
     * @return float
     */
    public function getMoustache()
    {
        return $this->moustache;
    }

    /**
     * @return float
     */
    public function getBeard()
    {
        return $this->beard;
    }

    /**
     * @return float
     */
    public function getSideburns()
    {
        return $this->sideburns;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'moustache' => $this->moustache,
            'beard' => $this->beard,
            'sideburns' => $this->sideburns
        ];
    }
}