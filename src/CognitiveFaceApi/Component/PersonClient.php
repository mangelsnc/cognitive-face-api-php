<?php

namespace CognitiveFaceApi\Component;

use CognitiveFaceApi\Client;
use CognitiveFaceApi\Resource\Face;
use CognitiveFaceApi\Resource\Person;
use CognitiveFaceApi\Resource\PersonGroup;

class PersonClient
{
    const RESOURCE_NAME = 'persongroups/%s/persons';

    /**
     * @var Client
     */
    private $client;

    /**
     * Person constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a single person
     * identified by its id.
     *
     * @param PersonGroup $group
     * @param $personId
     * @return Person
     * @throws \Exception
     */
    public function get(PersonGroup $group, $personId)
    {
        $uri = sprintf(self::RESOURCE_NAME, $group->getId());
        $uri .= '/' . $personId;

        $data = $this->client->doRequest($uri, 'GET');

        return new Person(
            $group->getId(),
            $data['personId'],
            $data['name'],
            $data['persistedFaceIds'],
            $data['userData']
        );
    }

    /**
     * Create a person
     *
     * @param PersonGroup $group
     * @param $name
     * @param string|null $userData
     * @return Person
     * @throws \Exception
     */
    public function create(PersonGroup $group, $name, $userData = null)
    {
        $uri = sprintf(self::RESOURCE_NAME, $group->getId());

        $data = $this->client->doRequest($uri, 'POST', [
            'name' => $name,
            'userData' => $userData
        ]);

        return new Person(
            $group->getId(),
            $data['personId'],
            $name,
            [],
            $userData
        );
    }

    /**
     * Update a person
     *
     * @param Person $person
     * @param $name
     * @param string|null $userData
     * @return Person
     * @throws \Exception
     */
    public function update(Person $person, $name, $userData = null)
    {
        $uri = sprintf(self::RESOURCE_NAME, $person->getGroup());
        $uri .= '/' . $person->getId();

        $this->client->doRequest($uri, 'PATCH', [
            'name' => $name,
            'userData' => $userData
        ]);

        return new Person(
            $person->getGroup(),
            $person->getId(),
            $name,
            $person->getFacesIds(),
            $userData
        );
    }

    /**
     * Delete a person
     *
     * @param Person $person
     * @throws \Exception
     */
    public function delete(Person $person)
    {
        $uri = sprintf(self::RESOURCE_NAME, $person->getGroup());
        $uri .= '/' . $person->getId();

        $this->client->doRequest($uri, 'DELETE');
    }

    /**
     * Get a person face
     *
     * @param Person $person
     * @param $faceId
     * @return Face
     * @throws \Exception
     */
    public function getFace(Person $person, $faceId)
    {
        $uri = sprintf(self::RESOURCE_NAME, $person->getGroup());
        $uri .= '/' . $person->getId() . '/persistedFaces/' . $faceId;

        $face = $this->client->doRequest($uri, 'GET');

        return new Face($face['faceId'], $face['userData']);
    }

    /**
     * Get a person faces
     *
     * @param Person $person
     * @return array
     * @throws \Exception
     */
    public function getAllFaces(Person $person)
    {
        $faces = [];

        foreach ($person->getFacesIds() as $faceId) {
            $uri = sprintf(self::RESOURCE_NAME, $person->getGroup());
            $uri .= '/' . $person->getId() . '/persistedFaces/' . $faceId;

            $face = $this->client->doRequest($uri, 'GET');
            $faces[] = new Face($face['persistedFaceId'], $face['userData']);
        }

        return $faces;
    }

    /**
     * @param Person $person
     * @param $url
     * @return Person
     */
    public function addFace(Person $person, $url)
    {
        $uri = sprintf(self::RESOURCE_NAME, $person->getGroup());
        $uri .= '/' . $person->getId() . '/persistedFaces';

        $face = $this->client->doRequest($uri, 'POST', [
            'url' => $url
        ]);

        $person->addFaceId($face['persistedFaceId']);

        return $person;
    }

    /**
     * @param Person $person
     * @param $faceId
     * @param $userData
     * @return Person
     */
    public function updateFace(Person $person, $faceId, $userData)
    {
        $uri = sprintf(self::RESOURCE_NAME, $person->getGroup());
        $uri .= '/' . $person->getId() . '/persistedFaces/' . $faceId;

        $this->client->doRequest($uri, 'PATCH', [
            'userData' => $userData
        ]);

        return $person;
    }

    /**
     * @param Person $person
     * @param $faceId
     * @return Person
     */
    public function deleteFace(Person $person, $faceId)
    {
        $uri = sprintf(self::RESOURCE_NAME, $person->getGroup());
        $uri .= '/' . $person->getId() . '/persistedFaces/' . $faceId;

        $this->client->doRequest($uri, 'DELETE');
        $person->removeFaceId($faceId);

        return $person;
    }
}