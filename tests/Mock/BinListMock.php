<?php

namespace Tests\Mock;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Service\BinList;

class BinListMock
{
    const API_LAYER_APIKEY = 'qwerty12345';
    const LOOKUP_BINLIST = 'https://mock.lookup.binlist.net/';

    public function getBinList($status, $body = null): BinList
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new BinList($client, self::API_LAYER_APIKEY, self::LOOKUP_BINLIST);
    }
}