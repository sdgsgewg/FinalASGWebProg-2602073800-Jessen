<?php

namespace App\Services;

use GuzzleHttp\Client;

class PexelsService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.pexels.com/v1/']);
        $this->apiKey = env('PEXELS_API_KEY');
    }

    public function getRandomImage($query = 'nature')
    {
        $endpoint = 'search';
        $params = [
            'query' => $query,
            'per_page' => 1,
        ];

        try {
            $response = $this->client->get($endpoint, [
                'query' => $params,
                'headers' => ['Authorization' => $this->apiKey],
            ]);
            $data = json_decode($response->getBody()->getContents(), true);

            return $data['photos'][0]['src']['medium'] ?? null;
        } catch (\Exception $e) {
            // Log error jika perlu
            return null; // Kembalikan null jika ada error
        }
    }
}
