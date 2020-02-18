<?php

declare(strict_types=1);

namespace Ronald\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Ronald\CommissionTask\Service\CurrencyConversion;

class CurrencyConversionDivideTest extends TestCase
{
    /**
     * @var CurrencyConversion
     */
    private $currencyConversion;

    public function setUp()
    {
        $this->currencyConversion = new CurrencyConversion(true);
    }

    /**
     * @param float $cashInAmount
     * @param string $currency
     * @param string $expectation
     *
     * @dataProvider dataProviderForCurrencyConversion
     */
    public function testCurrencyConversionDivide(float $cashInAmount, string $currency, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->currencyConversion->convertCurrency($currency, $cashInAmount)
        );
    }

    public function dataProviderForCurrencyConversion(): array
    {
        return [
            'convert to EUR from EUR(value unchanged)' => ['1000', 'EUR', '1000'],
            'convert to EUR from USD' => ['2000', 'JPY', '15.44043850845364'],
            'convert to EUR from JPY' => ['3000', 'USD', '2609.376359050187'],
        ];
    }
}

?>