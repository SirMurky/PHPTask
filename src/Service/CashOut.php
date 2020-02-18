<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Service;

require_once('CurrencyConversion.php');

class CashOut
{
    private $legalFeeMinimum;
    private $defaultFee;

    public function __construct(float $legalFeeMinimum, float $defaultFee)
    {
        $this->legalFeeMinimum = $legalFeeMinimum;
        $this->defaultFee = $defaultFee;
    }

    //Function calculates fee for both natural and legal person
    //Parameters:
    //  casOutAmount - int type of amount that is being cashed in;
    //  userType - legal or natural person, string type;
    public function calculateFee(float $cashOutAmount, string $userType, float $freeOfFeeAmount, string $currency)
    {
        if ($cashOutAmount < 0) { 
            return("Cash amount can not be negative numbers!");
        }

        $pow = pow(10, 1);
        if (strcmp($userType, "legal") === 0) {
            if ($cashOutAmount * $this->defaultFee / 100 < $this->legalFeeMinimum) {
                if (strpos($currency, "EUR") === false) {
                   return $this->legalFeeMinimum; 
                }
                return (ceil($pow * $this->legalFeeMinimum) + ceil($pow * $this->legalFeeMinimum - ceil($pow * $this->legalFeeMinimum))) / $pow;
            }
            if (strpos($currency, "EUR") === false && $cashOutAmount != 0) {
                return $cashOutAmount;  
            }
            return (ceil($pow * $cashOutAmount * $this->defaultFee / 100) + ceil($pow * $cashOutAmount * $this->defaultFee / 100 - ceil($pow * $cashOutAmount * $this->defaultFee / 100))) / $pow;

        } else if(strcmp($userType, "natural") === 0) {
            if (strpos($currency, "EUR") === false && $cashOutAmount != 0) {
              return ($cashOutAmount - $freeOfFeeAmount) * $this->defaultFee / 100;  
            }
            return (ceil($pow * ($cashOutAmount - $freeOfFeeAmount) * $this->defaultFee / 100) + ceil($pow * ($cashOutAmount - $freeOfFeeAmount) * $this->defaultFee / 100 - ceil($pow * ($cashOutAmount - $freeOfFeeAmount) * $this->defaultFee / 100))) / $pow;
        } else {
            return("Only 'natural' and 'legal' persons are accepted!");
        }   
    }
}
?>