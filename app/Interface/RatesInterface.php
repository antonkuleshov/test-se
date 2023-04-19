<?php

namespace Interface;

interface RatesInterface
{
    public function getRate(string $currency): float;
}