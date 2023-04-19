<?php

namespace Tests\Mock;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Service\Rates;

class RatesMock
{
    const API_LAYER_APIKEY = 'qwerty12345';
    const EXCHANGE_RATES_API = 'https://mock.api.apilayer.com/exchangerates_data/latest';

    public function getRates($status, $body = null): Rates
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new Rates($client, self::API_LAYER_APIKEY, self::EXCHANGE_RATES_API);
    }
}