<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Calculator;

use Money\Money;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Calculator\EarnedInterestCalculator;

class EarnedInterestCalculatorTest extends TestCase
{
    protected EarnedInterestCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new EarnedInterestCalculator();
    }

    #[Test]
    public function test_gets_earned_interest(): void
    {
        $outputInvestor1 = $this->calculator->getEarnedInterestAmount(
            new Money('100000', new Currency('GBP')),
            2.8064516129032258064516129032259
        );

        $this->assertEquals(
            new Money('2806', new Currency('GBP')),
            $outputInvestor1
        );

        $outputInvestor3 = $this->calculator->getEarnedInterestAmount(
            new Money('50000', new Currency('GBP')),
            4.2580645161290322580645161290322
        );

        $this->assertEquals(
            new Money('2129', new Currency('GBP')),
            $outputInvestor3
        );
    }
}
