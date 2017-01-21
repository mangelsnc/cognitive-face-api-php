<?php

namespace CognitiveFaceApi\Resource;

class FaceAttributes
{
    const AGE = 'age';
    const GENDER = 'gender';
    const HEAD_POSE = 'headPose';
    const SMILE = 'smile';
    const FACIAL_HAIR = 'facialHair';
    const GLASSES = 'glasses';

    /**
     * @var float
     */
    private $age;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var HeadPose
     */
    private $headPose;

    /**
     * @var float
     */
    private $smile;

    /**
     * @var FacialHair
     */
    private $facialHair;

    /**
     * @var string
     */
    private $glasses;

    /**
     * FaceAttributes constructor.
     * @param float $age
     * @param string $gender
     * @param HeadPose $headPose
     * @param string $smile
     * @param FacialHair $facialHair
     * @param string$glasses
     */
    public function __construct(
        $age,
        $gender,
        $headPose,
        $smile,
        $facialHair,
        $glasses
    ) {
        $this->age = $age;
        $this->gender = $gender;
        $this->headPose = $headPose;
        $this->smile = $smile;
        $this->facialHair = $facialHair;
        $this->glasses = $glasses;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getHeadPose()
    {
        return $this->headPose;
    }

    /**
     * @return mixed
     */
    public function getSmile()
    {
        return $this->smile;
    }

    /**
     * @return mixed
     */
    public function getFacialHair()
    {
        return $this->facialHair;
    }

    /**
     * @return mixed
     */
    public function getGlasses()
    {
        return $this->glasses;
    }

    public function toArray()
    {
        return [
            'age' => $this->age,
            'gender' => $this->gender,
            'headPose' => $this->headPose->toArray(),
            'smile' => $this->smile,
            'facialHair' => $this->facialHair->toArray(),
            'glasses' => $this->glasses
        ];
    }

    /**
     * @return array
     */
    public static function getAllowedFaceAttributes()
    {
        return [
            self::AGE,
            self::GENDER,
            self::HEAD_POSE,
            self::SMILE,
            self::FACIAL_HAIR,
            self::GLASSES
        ];
    }
}