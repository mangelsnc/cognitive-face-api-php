<?php

namespace CognitiveFaceApi\Component;

use CognitiveFaceApi\Client;
use CognitiveFaceApi\Resource\Person;
use CognitiveFaceApi\Resource\PersonGroup;

class PersonGroupManager
{
    const RESOURCE_NAME = 'persongroups';

    /**
     * @var Client
     */
    private $client;

    /**
     * PersonGroup constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all PersonGroup
     *
     * @return array
     * @throws \Exception
     */
    public function listAll(): array
    {
        $data = $this->client->doRequest(self::RESOURCE_NAME, 'GET');
        $groups = [];

        foreach ($data as $groupData) {
            $group = new PersonGroup(
                $groupData['personGroupId'],
                $groupData['name'],
                $groupData['userData']
            );

            $groups[] = $group;
        }

        return $groups;
    }

    /**
     * Get a single PersonGroup
     * identified by its id.
     *
     * @param string $personGroupId
     * @return PersonGroup
     * @throws \Exception
     */
    public function get($personGroupId): PersonGroup
    {
        $uri = self::RESOURCE_NAME . '/' . $personGroupId;

        $groupData = $this->client->doRequest($uri, 'GET');

        return new PersonGroup(
            $groupData['personGroupId'],
            $groupData['name'],
            $groupData['userData']
        );
    }

    /**
     * Create a PersonGroup
     *
     * @param string $personGroupId
     * @param string|null $name
     * @param string|null $userData
     * @return null
     * @throws \Exception
     */
    public function create($personGroupId, $name = null, $userData = null)
    {
        $name = null === $name ? $personGroupId : $name;
        $uri = self::RESOURCE_NAME . '/' . $personGroupId;

        $groupData = $this->client->doRequest($uri, 'PUT', [
            'name' => $name,
            'userData' => $userData
        ]);

        return new PersonGroup(
            $groupData['personGroupId'],
            $groupData['name'],
            $groupData['userData']
        );
    }

    /**
     * Update a PersonGroup
     *
     * @param PersonGroup $group
     * @param string $name
     * @param string $userData
     * @return PersonGroup
     * @throws \Exception
     */
    public function update(PersonGroup $group, $name, $userData): PersonGroup
    {
        $uri = self::RESOURCE_NAME . '/' . $group->getId();

        $this->client->doRequest($uri, 'PATCH', [
            'name' => $name,
            'userData' => $userData
        ]);

        return new PersonGroup(
            $group->getId(),
            $name,
            $userData
        );
    }

    /**
     * Delete a PersonGroup
     *
     * @param PersonGroup $group
     * @return boolean
     * @throws \Exception
     */
    public function delete(PersonGroup $group): bool
    {
        $uri = self::RESOURCE_NAME . '/' . $group->getId();

        $this->client->doRequest($uri, 'DELETE');

        return true;
    }

    /**
     * Train a PersonGroup
     *
     * @param PersonGroup $group
     * @return boolean
     * @throws \Exception
     */
    public function train(PersonGroup $group): bool
    {
        $uri = self::RESOURCE_NAME . '/' . $group->getId() . '/train';

        $this->client->doRequest($uri, 'POST');

        return true;
    }

    /**
     * Get a PersonGroup training status
     *
     * @param PersonGroup $group
     * @return array
     * @throws \Exception
     */
    public function trainingStatus(PersonGroup $group): array
    {
        $uri = self::RESOURCE_NAME . '/' . $group->getId() . '/training';

        $status = $this->client->doRequest($uri, 'GET');

        return json_decode($status, true);
    }

    /**
     * List all persons
     *
     * @param PersonGroup $group
     * @return array
     * @throws \Exception
     */
    public function getPersons(PersonGroup $group): array
    {
        $uri = sprintf(self::RESOURCE_NAME . '/%s/persons', $group->getId());
        $data = $this->client->doRequest($uri, 'GET');
        $persons = [];

        foreach ($data as $personData) {
            $persons[] = new Person(
                $group->getId(),
                $personData['personId'],
                $personData['name'],
                $personData['persistedFaceIds'],
                $personData['userData']
            );
        }

        return $persons;
    }
}