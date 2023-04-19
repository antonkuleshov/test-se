<?php

namespace Interface;

interface BinListInterface
{
    public function getCountryAlpha2(string $bin): string;
}