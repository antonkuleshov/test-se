<?php

namespace Tests\Service;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use Service\BinList;

class BinListTest extends TestCase
{
    private string $apiLayerApiKey;
    private string $lookupBinList;

    const API_LAYER_APIKEY = 'qwerty12345';

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->apiLayerApiKey = $_ENV['API_LAYER_APIKEY'];
        $this->lookupBinList = $_ENV['LOOKUP_BINLIST'];
    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function testGetCountryAlpha2(): void
    {
        $binList = new BinList($this->apiLayerApiKey, $this->lookupBinList);

        $this->assertEquals('DK', $binList->getCountryAlpha2('45717360'));
        $this->assertEquals('LT', $binList->getCountryAlpha2('516793'));
        $this->assertEquals('JP', $binList->getCountryAlpha2('45417360'));
        $this->assertEquals('LT', $binList->getCountryAlpha2('516793'));
    }

    private function getBinList($status, $body = null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new BinList($client, 'http://mocked.postcodes.xyz/');
    }
}