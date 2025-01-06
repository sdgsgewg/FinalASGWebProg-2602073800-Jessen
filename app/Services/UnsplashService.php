<?php

namespace App\Services;

use GuzzleHttp\Client;

class UnsplashService
{
    protected $client;
    protected $accessKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.unsplash.com/']);
        $this->accessKey = env('UNSPLASH_ACCESS_KEY');
    }

    public function getRandomImage($query = null)
    {
        $endpoint = 'photos/random';
        $params = [
            'query' => $query,
            'client_id' => $this->accessKey,
        ];

        $response = $this->client->get($endpoint, ['query' => $params]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['urls']['regular'] ?? null;
    }
}
