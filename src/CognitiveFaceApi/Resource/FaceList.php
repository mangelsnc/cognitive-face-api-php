<?php

namespace CognitiveFaceApi\Resource;

class FaceList
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var null
     */
    private $userData;

    /**
     * @var array
     */
    private $facesIds;

    /**
     * FaceList constructor.
     * @param string $id
     * @param string $name
     * @param null $userData
     * @param array $facesIds
     */
    public function __construct($id, $name, $userData = null, $facesIds = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->userData = $userData;
        $this->facesIds = $facesIds;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @param $faceId
     * @return FaceList
     */
    public function addFaceId($faceId)
    {
        $this->facesIds[] = $faceId;

        return $this;
    }

    /**
     * @param $faceId
     * @return FaceList
     */
    public function removeFaceId($faceId)
    {
        $index = array_search($faceId, $this->facesIds);
        unset($this->facesIds[$index]);

        return $this;
    }

    /**
     * @return array
     */
    public function getFacesIds()
    {
        return $this->facesIds;
    }
}