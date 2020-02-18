<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Service;

require_once('CurrencyConversion.php');

class CashIn
{
    private $cashInFee;
    private $maxCashInFee;

    public function __construct(float $cashInFee, float $maxCashInFee)
    {
        $this->cashInFee = $cashInFee;
        $this->maxCashInFee = $maxCashInFee;
    }

    public function calculateFee(float $cashInAmount, string $currency)
    {
        if ($cashInAmount < 0) {
            return("You can not cash in negative numbers!");
        }

        $convertedFee = new CurrencyConversion(false);
        $calculatedFee = $cashInAmount * $convertedFee->convertCurrency($currency, $this->cashInFee) / 100;
        $convertedMax = $convertedFee->convertCurrency($currency, $this->maxCashInFee);
        if ($calculatedFee == 0) {
            return ("There was problem accessing conversion rates .txt");
        }

        if ($calculatedFee < $convertedMax) {
            $pow = pow(10, 1);
            return (ceil($pow * $calculatedFee) + ceil($pow * $calculatedFee - ceil($pow * $calculatedFee))) / $pow;
        }

        return($convertedMax);  
    }
}
?>