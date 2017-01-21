<?php

namespace CognitiveFaceApi\Resource;

class HeadPose
{
    /**
     * @var float
     */
    private $roll;

    /**
     * @var float
     */
    private $yaw;

    /**
     * @var float
     */
    private $pitch;

    public function __construct($roll, $yaw, $pitch)
    {
        $this->roll = $roll;
        $this->yaw = $yaw;
        $this->pitch = $pitch;
    }

    /**
     * @return float
     */
    public function getRoll()
    {
        return $this->roll;
    }

    /**
     * @return float
     */
    public function getYaw()
    {
        return $this->yaw;
    }

    /**
     * @return float
     */
    public function getPitch()
    {
        return $this->pitch;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'roll' => $this->roll,
            'yaw' => $this->yaw,
            'pitch' => $this->pitch
        ];
    }
}