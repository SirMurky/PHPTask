<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Service;

class CurrencyConversion
{
    private $isDivide;

    public function __construct(bool $isDivide)
    {
        $this->isDivide = $isDivide;
    }

    public function convertCurrency(string $currency, float $cashFee)
    {
        if (strpos($currency, "EUR") === false) {
            $conversionDoc = fopen('C:\Users\rvjaz\Desktop\SendASAP\src\Service\ConversionRates.txt','r');
            if ($conversionDoc) {
                while (($line = fgets($conversionDoc)) !== false) {
                    $currencyPos = strpos($line, $currency);
                    if ($currencyPos === false) {
                        continue;
                    }

                    $currencyRate = substr($line, strpos($line, ":", $currencyPos) + 1);
                    fclose($conversionDoc);
                    if ($this->isDivide) {
                        return($cashFee / floatval($currencyRate)); 
                    }              
                    return($cashFee * floatval($currencyRate));
                }
            } else {
                return(0);
            }
        } else {
            return $cashFee;
        }
    }
}
?>