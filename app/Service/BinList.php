<?php

namespace Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Interface\BinListInterface;

readonly class BinList implements BinListInterface
{
    public function __construct(
        private Client $client,
        private string $apiLayerApiKey,
        private string $lookupBinList
    ) {}

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function getCountryAlpha2(string $bin): string
    {
        if (!$bin) {
            throw new \Exception('Bin is required');
        }

        try {
            $res = $this->client->get($this->lookupBinList . $bin, [
                'headers' => [
                    'apikey' => $this->apiLayerApiKey,
                ]
            ]);
            $content = json_decode($res->getBody());

            return $content->country->alpha2;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get binlist data', 400);
        }
    }
}