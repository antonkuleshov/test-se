<?php

namespace Service;

use GuzzleHttp\Exception\GuzzleException;

class CalculateCommission
{
    const EU_COUNTRIES = ['AT','BE','BG','CY','CZ','DE','DK','EE','ES','FI','FR','GR','HR',
        'HU','IE','IT','LT','LU','LV','MT','NL','PO','PT','RO','SE','SI','SK'];

    const EUR_CURRENCY = 'EUR';

    public function __construct(private readonly BinList $binList, private readonly Rates $rates)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function calculate(object $data): float
    {
        $countryAlpha2 = $this->binList->getCountryAlpha2($data->bin);
        $isEu = $this->isContainToEu($countryAlpha2);

        $currency = $data->currency;

        $rate = $this->rates->getRate($currency);

        $amntFixed = 0;

        if ($currency === self::EUR_CURRENCY) {
            $amntFixed = $data->amount;
        } elseif ($rate > 0) {
            $amntFixed = $data->amount / $rate;
        }

        return $amntFixed * ($isEu ? 0.01 : 0.02);
    }

    public function isContainToEu(string $countryShortName): bool
    {
        return in_array($countryShortName, self::EU_COUNTRIES);
    }
}