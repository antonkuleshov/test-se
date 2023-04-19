<?php

namespace Tests\Service;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Tests\Mock\BinListMock;

class BinListTest extends TestCase
{
    private BinListMock $binList;

    public function setUp(): void
    {
        $this->binList = new BinListMock();
    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function testGetCountryAlpha2(): void
    {
        $body = file_get_contents(dirname(__DIR__, 1) . '/Mock/binlist.txt');

        $binList = $this->binList->getBinList(200, $body);

        $this->assertEquals('JP', $binList->getCountryAlpha2('45417360'));
    }
}