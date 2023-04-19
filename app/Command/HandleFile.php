<?php

namespace Command;

use Service\CalculateCommission;

class HandleFile
{
    public function __construct(private readonly CalculateCommission $calculateCommission)
    {
    }

    public function parse(string $filePath): void
    {
        $handle = fopen($filePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data = json_decode($line);

                $result = $this->calculateCommission->calculate($data);

                print "$result\n";
            }

            fclose($handle);
        }
    }
}