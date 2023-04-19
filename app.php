<?php

use Command\HandleFile;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Service\BinList;
use Service\CalculateCommission;
use Service\Rates;

require_once "vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiLayerApiKey = $_ENV['API_LAYER_APIKEY'];
$lookupBinList = $_ENV['LOOKUP_BINLIST'];
$exchangeRatesApi = $_ENV['EXCHANGE_RATES_API'];

$filePath = $argv[1];

if (!isset($filePath)) {
    throw new \Exception('File not to be added');
}

$client = new Client();
$binList = new BinList($client, $apiLayerApiKey, $lookupBinList);
$rates = new Rates($client, $apiLayerApiKey, $exchangeRatesApi);

$calculateCommission = new CalculateCommission($binList, $rates);
$handle = new HandleFile($calculateCommission);
$handle->parse($filePath);
