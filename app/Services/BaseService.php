<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BaseService
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected Client $client;

    public function __construct(array $config)
    {
        $this->client = new Client($config);
    }

    /**
     * Attempt to parse response from GET request
     *  If fail - send log to error monitoring service
     *
     * @param  string  $uri
     * @param  array  $options
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $options = []): array
    {
        try {
            $response = $this->client->get($uri, $options);
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            if ($response) {
                // Log to error monitoring service
            }
            throw $e;
        }

        $contents = $response->getBody()->getContents();
        return json_decode($contents, true);
    }
}
