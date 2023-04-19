<?php

namespace Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Interface\RatesInterface;

class Rates implements RatesInterface
{
    public function __construct(
        private readonly Client $client,
        private readonly string $apiLayerApiKey,
        private readonly string $exchangeRatesApi
    ) {}

    /**
     * @throws GuzzleException
     */
    public function getRate(string $currency): float
    {
        $res = $this->client->get($this->exchangeRatesApi, [
            'headers' => [
                'apikey' => $this->apiLayerApiKey,
            ]
        ]);
        $content = json_decode($res->getBody());

        return $content->rates->{$currency};
    }
}