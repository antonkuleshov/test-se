<?php

namespace Tests\Service;

use Dotenv\Dotenv;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Service\BinList;
use Service\CalculateCommission;
use Service\Rates;
use Tests\Mock\BinListMock;
use Tests\Mock\RatesMock;

class CalculateCommissionTest extends TestCase
{
    private BinList $binList;
    private Rates $rates;
    private object $data;

    public function setUp(): void
    {
        $binListBody = file_get_contents(dirname(__DIR__, 1) . '/Mock/binlist.txt');
        $ratesBody = file_get_contents(dirname(__DIR__, 1) . '/Mock/rates.txt');

        $binListMock = new BinListMock();
        $ratesMock = new RatesMock();

        $this->binList = $binListMock->getBinList(200, $binListBody);
        $this->rates = $ratesMock->getRates(200, $ratesBody);
        $this->data = json_decode('{"bin":"45717360","amount":"100.00","currency":"EUR"}');
    }

    public function testIsContainToEu(): void
    {
        $calculateCommission = new CalculateCommission($this->binList, $this->rates);

        $this->assertTrue($calculateCommission->isContainToEu('AT'));
        $this->assertNotTrue($calculateCommission->isContainToEu('AV'));
    }

    /**
     * @throws GuzzleException
     */
    public function testCalculate(): void
    {
        $calculateCommission = new CalculateCommission($this->binList, $this->rates);

        $this->assertIsFloat($calculateCommission->calculate($this->data));
    }
}