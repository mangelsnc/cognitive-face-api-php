<?php

namespace CognitiveFaceApi\Resource;

class PersonGroup
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
     * @var string
     */
    private $userData;

    /**
     * PersonGroup constructor.
     * @param $id
     * @param $name
     * @param null $userData
     */
    public function __construct($id, $name, $userData = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userData = $userData;

        return $this;
    }

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
     * @return string
     */
    public function getUserData()
    {
        return $this->userData;
    }
}