<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Ronald\CommissionTask\Service\CashIn;

class CashInTest extends TestCase
{
    /**
     * @var CashIn
     */
    private $cashIn;

    public function setUp()
    {
        $this->cashIn = new CashIn(0.03, 5);
    }

    /**
     * @param float $cashInAmount
     * @param string $currency
     * @param string $expectation
     *
     * @dataProvider dataProviderForCashInCalculateFee
     */
    public function testCashInCalculateFee(float $cashInAmount, string $currency, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->cashIn->calculateFee($cashInAmount, $currency)
        );
    }

    public function dataProviderForCashInCalculateFee(): array
    {
        return [
            'calculate fee in EUR' => ['1000', 'EUR', '0.3'],
            'calculate fee in JPY' => ['1000', 'JPY', '38.9'],
            'calculate fee in USD' => ['1000', 'USD', '0.4'],
        ];
    }
}

?>