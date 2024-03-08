<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use App\Entity\SparePart;

class SparePartsApiService
{
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::createForBaseUri('http://localhost:8000');
    }

    public function getSpareParts()
    {
        $response = $this->client->request('GET', '/spare-parts');

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error fetching spare parts from API');
        }

        $data = json_decode($response->getContent(), true);

        $spareParts = [];
        foreach ($data as $item) {
            $spareParts[] = new SparePart($item['id'], $item['name'], $item['price']);
        }

        return $spareParts;
    }
}

