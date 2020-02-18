<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Ronald\CommissionTask\Service\CurrencyConversion;

class CurrencyConversionMultiplyTest extends TestCase
{
    /**
     * @var CurrencyConversion
     */
    private $currencyConversion;

    public function setUp()
    {
        $this->currencyConversion = new CurrencyConversion(false);
    }

    /**
     * @param float $cashInAmount
     * @param string $currency
     * @param string $expectation
     *
     * @dataProvider dataProviderForCurrencyConversion
     */
    public function testCurrencyConversionMultiply(float $cashInAmount, string $currency, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->currencyConversion->convertCurrency($currency, $cashInAmount)
        );
    }

    public function dataProviderForCurrencyConversion(): array
    {
        return [
            'convert to EUR fee(value unchanged)' => ['0.03', 'EUR', '0.03'],
            'convert to USD fee' => ['0.03', 'JPY', '3.8859'],
            'convert to JPY fee' => ['0.03', 'USD', '0.034491'],
        ];
    }
}

?>