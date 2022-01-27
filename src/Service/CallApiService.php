<?php

namespace App\Service;

use DateTime;
use App\Entity\Anime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService{
    private $client;

    public function __construct(HttpClientInterface $client){
        $this->client = $client;
    }

    public function getMovie($movie): array{
        return $this->getApi('&query=' . $movie);
    }

    public function getLenght($type): array{
        return $this->getApi('&type=' . $type);
    }



    private function getApi(string $var){
        $response = $this->client->request(
            'GET',
            'https://nautiljon.api.barthofu.com/search?&type=anime' . $var );

        return $response->toArray();
    }

    public function findDescription(string $var){
        $response = $this->client->request(
            'GET',
            'https://nautiljon.api.barthofu.com/getInfoFromURL?url=' . $var );

        return $response->toArray();
    } 
}
        