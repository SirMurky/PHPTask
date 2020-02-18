<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Ronald\CommissionTask\Service\CashOut;

class CashOutTest extends TestCase
{
    /**
     * @var CashOut
     */
    private $cashOut;

    public function setUp()
    {
        $this->cashOut = new CashOut(0.5, 0.3);
    }

    /**
     * @param float $cashOutAmount
     * @param string $userType
     * @param float $freeOfFeeAmount
     * @param string $currency
     * @param string $expectation
     *
     * @dataProvider dataProviderForCashOut
     */
    public function testCashOutFeeCalculation(float $cashOutAmount, string $currency, float $freeOfFeeAmount, string $userType, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->cashOut->calculateFee($cashOutAmount, $userType, $freeOfFeeAmount, $currency)
        );
    }

    public function dataProviderForCashOut(): array
    {
        return [
            'legal person cash out' => ['1000','legal', '0', 'EUR', '3'],
            'natural person cash out' => ['3000', 'natural', '1000', 'EUR', '5'],
            'random person cash out' => ['1000000', 'random', '0', 'EUR', "Only 'natural' and 'legal' persons are accepted!"],
        ];
    }
}

?>
