<?php

namespace App\Services\Elixir;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Proxy
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Proxy constructor.
     */
    function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://phoenix:4000/api/']);
    }


    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $method, string $uri = '', array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri, $options);
    }
}
