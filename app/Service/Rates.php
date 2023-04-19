<?php

namespace Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Interface\RatesInterface;

readonly class Rates implements RatesInterface
{
    public function __construct(
        private Client $client,
        private string $apiLayerApiKey,
        private string $exchangeRatesApi
    ) {}

    /**
     * @throws GuzzleException
     */
    public function getRate(string $currency): float
    {
        if (!$currency) {
            throw new \Exception('Currency is required');
        }

        try {
            $res = $this->client->get($this->exchangeRatesApi, [
                'headers' => [
                    'apikey' => $this->apiLayerApiKey,
                ]
            ]);
            $content = json_decode($res->getBody());

            return $content->rates->{$currency};
        } catch (\Exception $e) {
            throw new \Exception('Failed to get rates data', 400);
        }
    }
}