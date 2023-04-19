<?php

namespace Command;

use GuzzleHttp\Exception\GuzzleException;
use Service\CalculateCommission;

class HandleFile
{
    public function __construct(private readonly CalculateCommission $calculateCommission)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function parse(string $filePath): void
    {
        $handle = fopen($filePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data = json_decode($line);

                if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception("Input file is incorrect");
                }

                $result = $this->calculateCommission->calculate($data);

                print "$result\n";
            }

            fclose($handle);
        }
    }
}