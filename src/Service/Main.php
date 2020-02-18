<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Service;

require ('CashIn.php');
require ('CashOut.php');
require_once ('CurrencyConversion.php');

class Main
{
    public function getFees()
    {
        $csvPath = readline("Enter.csv file path: ");
        $csvFile = fopen($csvPath, 'r'); 
        if ($csvFile === false) {
            echo "Problem opening .csv file";
            return;
        }
        $csvDataArray = array();
        echo ".csv data: \n";
        //showing .csv data and storing data into array
        $loopCounter = 0;
        while (($row = fgetcsv($csvFile)) !== FALSE) {
            if ($loopCounter == 0) {
                $loopCounter++;
                continue;
            }
            echo $row[0]. "," .$row[1]. "," .$row[2]. "," .$row[3]. "," .$row[4]. "," .$row[5]. "\n";
            $convertCurrency = new CurrencyConversion(true);
            $row[4] = $convertCurrency->convertCurrency($row[5], floatval($row[4]));
            $csvDataArray[] = $row; 
        }
        fclose($csvFile);

        //calculating fees
        echo "script data: \n";
        $cashOutClass = new CashOut(0.50, 0.3);
        $cashInClass = new CashIn(0.03, 5);
        foreach ($csvDataArray as $csvRecord) {
            $cashAmount = 0;
            $cashOutId = 0;
            $firstDateWeek = date("w", strtotime($csvRecord[0]));
            if (strcmp($csvRecord[3], "cash_out") == 0) {
                foreach ($csvDataArray as $csvRecordFeeChecker) {
                    if ($csvRecordFeeChecker === $csvRecord) {
                        break;     
                    }
                    $secondaryDateWeek = date("w", strtotime($csvRecordFeeChecker[0]));
                    if ($csvRecordFeeChecker[1] == $csvRecord[1] && strcmp($csvRecordFeeChecker[3], "cash_out") == 0 
                        && ($firstDateWeek >= $secondaryDateWeek || $firstDateWeek == 0)) {
                        $cashAmount += floatval($csvRecordFeeChecker[4]); 
                        $cashOutId++;
                    }
                }
                if ($cashOutId <= 3) {
                    if ($cashAmount == 0) {
                        $cashAmount = floatval($csvRecord[4]);
                    if ($cashAmount > 1000) {
                        $freeOfCharge = 1000;
                    } else {
                        $freeOfCharge = $cashAmount;
                    }
                    } else {
                        if ($cashAmount > 1000) {
                            $cashAmount = floatval($csvRecord[4]);
                            $freeOfCharge = 0;
                        } else {
                            $freeOfCharge = 1000 - $cashAmount;
                            $cashAmount = floatval($csvRecord[4]); 
                        }
                    }
                } else {
                    $cashAmount = floatval($csvRecord[4]); 
                    $freeOfCharge = 0;
                }

                $calculatedValue = $cashOutClass->calculateFee($cashAmount, $csvRecord[2], $freeOfCharge, $csvRecord[5]); 

                if (strpos($csvRecord[5], "EUR") === false && $calculatedValue != 0) {
                    $convertCurrency = new CurrencyConversion(false);
                    $pow = pow(10, 1);
                    $originalCurrency = $convertCurrency->convertCurrency($csvRecord[5], floatval($calculatedValue)); 
                    $calculatedValue = (ceil($pow * $originalCurrency) + ceil($pow * $originalCurrency- ceil($pow * $originalCurrency))) / $pow;
                }
                echo $calculatedValue;             
            }
            else {
                echo $cashInClass->calculateFee(floatval($csvRecord[4]), $csvRecord[5]); 
            }
            echo "\n";
        }
    }
}

$executable = new Main();
$executable->getFees();

?>