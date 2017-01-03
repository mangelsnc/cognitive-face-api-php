<?php

namespace CognitiveFaceApi\Resource;

class Person
{
    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $facesIds;

    /**
     * @var string
     */
    private $userData;

    public function __construct($group, $id, $name, $facesIds, $userData = null)
    {
        $this->group = $group;
        $this->id = $id;
        $this->name = $name;
        $this->userData = $userData;
        $this->facesIds = $facesIds;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
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
     * @param $faceId
     * @return Person
     */
    public function addFaceId($faceId)
    {
        $this->facesIds[] = $faceId;

        return $this;
    }

    /**
     * @param $faceId
     * @return Person
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

    /**
     * @return string
     */
    public function getUserData()
    {
        return $this->userData;
    }

    public function toArray()
    {
        return [
            'group' => $this->getGroup(),
            'id' => $this->getId(),
            'name' => $this->getName(),
            'facesIds' => $this->getFacesIds(),
            'userData' => $this->getUserData(),
        ];
    }
}