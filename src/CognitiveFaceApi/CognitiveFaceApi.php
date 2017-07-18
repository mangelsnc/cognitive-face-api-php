<?php

namespace CognitiveFaceApi;

use CognitiveFaceApi\Component\FaceManager;
use CognitiveFaceApi\Component\FaceListManager;
use CognitiveFaceApi\Component\PersonManager;
use CognitiveFaceApi\Component\PersonGroupManager;

class CognitiveFaceApi
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var FaceListManager
     */
    public $faceList;

    /**
     * @var PersonGroupManager
     */
    public $personGroup;

    /**
     * @var PersonManager
     */
    public $person;

    /**
     * @var FaceManager
     */
    public $face;

    public function __construct($subscriptionKey)
    {
        $this->client = new Client($subscriptionKey);
        $this->faceList = new FaceListManager($this->client);
        $this->personGroup = new PersonGroupManager($this->client);
        $this->person = new PersonManager($this->client);
        $this->face = new FaceManager($this->client);
    }
}