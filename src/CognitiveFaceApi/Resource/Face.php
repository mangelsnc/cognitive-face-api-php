<?php

namespace CognitiveFaceApi\Resource;

class Face
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userData;

    public function __construct($id, $userData = null)
    {
        $this->id = $id;
        $this->userData = $userData;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getUserData()
    {
        return $this->userData;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'userData' => $this->getUserData(),
        ];
    }
}