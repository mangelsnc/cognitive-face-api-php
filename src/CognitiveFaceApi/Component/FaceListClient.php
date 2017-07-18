<?php

namespace CognitiveFaceApi\Component;

use CognitiveFaceApi\Client;
use CognitiveFaceApi\Resource\FaceList;

class FaceListClient
{
    const RESOURCE_NAME = 'facelists';

    /**
     * @var Client
     */
    private $client;

    /**
     * FaceList constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all Faces List
     *
     * @return array
     * @throws \Exception
     */
    public function listAll()
    {
        $data = $this->client->doRequest(self::RESOURCE_NAME, 'GET');
        $lists = [];

        foreach ($data as $listData) {
            $persistedFaces = array_key_exists('persistedFaces', $listData) ? $listData['persistedFaces'] : [];

            $list = new FaceList(
                $listData['faceListId'],
                $listData['name'],
                $listData['userData'],
                $persistedFaces
            );

            $lists[] = $list;
        }

        return $lists;
    }

    /**
     * Get a single face list
     * identified by its id.
     *
     * @param string $listId
     * @return FaceList
     * @throws \Exception
     */
    public function get($listId)
    {
        $uri = self::RESOURCE_NAME . '/' . $listId;
        $listData = $this->client->doRequest($uri, 'GET');

        return new FaceList(
            $listData['faceListId'],
            $listData['name'],
            $listData['userData'],
            $listData['persistedFaces']
        );
    }

    /**
     * Create a Face List
     *
     * @param string $listId
     * @param null $name
     * @param string|null $userData
     * @return FaceList
     */
    public function create($listId, $name = null, $userData = null)
    {
        $name = null === $name ? $listId : $name;
        $uri = self::RESOURCE_NAME . '/' . $listId;

        $this->client->doRequest($uri, 'PUT', [
            'name' => $name,
            'userData' => $userData
        ]);

        return new FaceList(
            $listId,
            $name,
            $userData,
            []
        );
    }

    /**
     * Update a Face List
     *
     * @param FaceList $list
     * @param $name
     * @param string|null $userData
     * @return null
     * @internal param string $listId
     */
    public function update(FaceList $list, $name, $userData)
    {
        $uri = self::RESOURCE_NAME . '/' . $list->getId();

        $this->client->doRequest($uri, 'PATCH', [
            'name' => $name,
            'userData' => $userData
        ]);

        return new FaceList(
            $list->getId(),
            $name,
            $userData, $list->getFacesIds()
        );
    }

    /**
     * Delete a Face List
     *
     * @param FaceList $list
     * @return null
     * @throws \Exception
     */
    public function delete(FaceList $list)
    {
        $uri = self::RESOURCE_NAME . '/' . $list->getId();

        $this->client->doRequest($uri, 'DELETE');

        return true;
    }

    /**
     * Add a face to a Face List
     *
     * @param FaceList $list
     * @param string $url
     * @return FaceList
     * @throws \Exception
     */
    public function addFace(FaceList $list, $url)
    {
        $uri = self::RESOURCE_NAME . '/' . $list->getId() . '/persistedFaces';

        $faceData = $this->client->doRequest($uri, 'POST', [
            'url' => $url
        ]);

        $list->addFaceId($faceData['persistedFaceId']);

        return $list;
    }

    /**
     * Delete a face from a Face List
     *
     * @param FaceList $list
     * @param string $faceId
     * @return FaceList
     * @throws \Exception
     */
    public function deleteFace(FaceList $list, $faceId)
    {
        $uri = self::RESOURCE_NAME . '/' . $list->getId() . '/persistedFaces/' . $faceId;

        $this->client->doRequest($uri, 'DELETE');

        $list->removeFaceId($faceId);

        return $list;
    }
}