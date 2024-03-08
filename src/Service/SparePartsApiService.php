<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use App\Entity\SparePart;

class SparePartsApiService
{
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::createForBaseUri('http://http://external-spare-part-api.lndo.site/');
    }

    public function getSpareParts(array $ids = []): array
    {
        // Ensure that $ids is properly formatted for the query parameter
        $formattedIds = implode(',', $ids);
    
        // Make a request to the API with the given IDs
        $response = $this->client->request('GET', '/spare-parts', [
            'query' => [
                'ids' => $formattedIds,
            ],
        ]);

        dd($response->getContent());
    
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

