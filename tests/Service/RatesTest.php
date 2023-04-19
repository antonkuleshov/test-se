<?php

namespace Tests\Service;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Tests\Mock\RatesMock;

class RatesTest extends TestCase
{
    private RatesMock $rates;

    public function setUp(): void
    {
        $this->rates = new RatesMock();
    }

    /**
     * @throws GuzzleException
     */
    public function testGetRate()
    {
        $body = file_get_contents(dirname(__DIR__, 1) . '/Mock/rates.txt');

        $rates = $this->rates->getRates(200, $body);

        $this->assertEquals(1, $rates->getRate('EUR'));
    }
}