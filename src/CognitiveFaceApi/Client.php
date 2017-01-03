<?php

namespace CognitiveFaceApi;

use CognitiveFaceApi\Exception\ConcurrentOperationConflictException;
use CognitiveFaceApi\Exception\InvalidSubscriptionKeyException;
use CognitiveFaceApi\Exception\OutOfQuotaException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    const BASE_URL = 'https://api.projectoxford.ai/face/v1.0/';

    /**
     * @var string
     */
    private $subscriptionKey;

    /**
     * @var GuzzleClient
     */
    private $httpClient;

    /**
     * Client constructor.
     * @param $subscriptionKey
     */
    public function __construct($subscriptionKey)
    {
        $this->subscriptionKey = $subscriptionKey;
        $this->httpClient = new GuzzleClient([
            'base_uri' => self::BASE_URL
        ]);
    }

    /**
     * @param $uri
     * @param string $method
     * @param array $body
     * @return mixed
     * @throws \Exception
     */
    public function doRequest($uri, $method = 'GET', $body = [])
    {
        try {
            $response = $this->httpClient->request($method, $uri, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Ocp-Apim-Subscription-Key' => $this->subscriptionKey
                ],
                'json' => $body
            ]);
        } catch (\Exception $e) {
            throw $e;
        }

        if (!$this->isValidResponse($response)) {
            $this->handleInvalidResponse($response);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param GuzzleResponse $response
     * @return bool
     */
    private function isValidResponse(GuzzleResponse $response)
    {
        if (
            Response::HTTP_OK !== $response->getStatusCode()
            && Response::HTTP_ACCEPTED !== $response->getStatusCode()
        ) {
            return false;
        }

        return true;
    }

    /**
     * @param GuzzleResponse $response
     * @throws ConcurrentOperationConflictException
     * @throws InvalidSubscriptionKeyException
     * @throws OutOfQuotaException
     * @throws \Exception
     */
    private function handleInvalidResponse(GuzzleResponse $response)
    {
        switch ($response->getStatusCode()) {
            case Response::HTTP_UNAUTHORIZED:
                throw new InvalidSubscriptionKeyException($response->getReasonPhrase());
                break;

            case Response::HTTP_FORBIDDEN:
                throw new OutOfQuotaException($response->getReasonPhrase());
                break;

            case Response::HTTP_CONFLICT:
                throw new ConcurrentOperationConflictException($response->getReasonPhrase());
                break;

            case Response::HTTP_TOO_MANY_REQUESTS:
                throw new ConcurrentOperationConflictException($response->getReasonPhrase());
                break;

            default:
                throw new \Exception($response->getReasonPhrase(), $response->getStatusCode());
        }
    }
}