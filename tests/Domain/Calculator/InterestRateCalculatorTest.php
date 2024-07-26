<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Calculator;

use DateTime;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;
use LendInvest\CodingTest\Domain\Calculator\InterestRateCalculator;

class InterestRateCalculatorTest extends TestCase
{
    protected InterestRateCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new InterestRateCalculator();
    }

    #[Test]
    public function test_can_calculate_daily_interest_rate(): float
    {
        $output = $this->calculator->getDailyInterestRate(
            3,
            DateTime::createFromFormat('d/m/Y', '31/10/2023')
        );

        $this->assertEqualsWithDelta(0.096774193548387, $output, 0.0001);
        return $output;
    }

    #[Depends('test_can_calculate_daily_interest_rate')]
    public function test_can_get_period_interest_rate(float $dailyRate): void
    {
        $output = $this->calculator->getInvestedPeriodInterestRate(
            $dailyRate,
            29
        );

        $this->assertEqualsWithDelta(2.8064516129032, $output, 0.0001);
    }
}
