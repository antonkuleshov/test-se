<?php

namespace Tests\Service;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Service\BinList;
use Service\CalculateCommission;
use Service\Rates;

class CalculateCommissionTest extends TestCase
{
    private BinList $binList;
    private Rates $rates;
    private object $data;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $apiLayerApiKey = $_ENV['API_LAYER_APIKEY'];
        $lookupBinList = $_ENV['LOOKUP_BINLIST'];
        $exchangeRatesApi = $_ENV['EXCHANGE_RATES_API'];

        $this->binList = new BinList($apiLayerApiKey, $lookupBinList);
        $this->rates = new Rates($apiLayerApiKey, $exchangeRatesApi);
        $this->data = json_decode('{"bin":"45717360","amount":"100.00","currency":"EUR"}');
    }

    public function testIsContainToEu(): void
    {
        $calculateCommission = new CalculateCommission($this->binList, $this->rates);

        $this->assertTrue($calculateCommission->isContainToEu('AT'));
        $this->assertNotTrue($calculateCommission->isContainToEu('AV'));
    }

    public function testCalculate(): void
    {
        $calculateCommission = new CalculateCommission($this->binList, $this->rates);

        $this->assertIsFloat($calculateCommission->calculate($this->data));
    }
}