<?php

namespace Tests\Service;

use Dotenv\Dotenv;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Service\Rates;

class RatesTest extends TestCase
{
    private string $apiLayerApiKey;
    private string $exchangeRatesApi;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->apiLayerApiKey = $_ENV['API_LAYER_APIKEY'];
        $this->exchangeRatesApi = $_ENV['EXCHANGE_RATES_API'];
    }

    /**
     * @throws GuzzleException
     */
    public function testGetRate()
    {
        $rates = new Rates($this->apiLayerApiKey, $this->exchangeRatesApi);

        $this->assertEquals(1, $rates->getRate('EUR'));
    }
}