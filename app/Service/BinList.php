<?php

namespace Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Interface\BinListInterface;

class BinList implements BinListInterface
{
    public function __construct(
        private readonly Client $client,
        private readonly string $apiLayerApiKey,
        private readonly string $lookupBinList
    ) {}

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function getCountryAlpha2(string $bin): string
    {
        $res = $this->client->get($this->lookupBinList . $bin, [
            'headers' => [
                'apikey' => $this->apiLayerApiKey,
            ]
        ]);
        $content = json_decode($res->getBody());

        return $content->country->alpha2;
    }
}