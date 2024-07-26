<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Calculator;

use DateTime;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Calculator\DateIntervalCalculator;

class DateIntervalCalculatorTest extends TestCase
{
    protected DateIntervalCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new DateIntervalCalculator();
    }

    #[Test]
    public function test_gets_investment_period(): void
    {
        $startDate = DateTime::createFromFormat('d/m/Y', '03/10/2023');
        $endDate = DateTime::createFromFormat('d/m/Y', '31/10/2023');
        $expectedResult = 29;

        $output = $this->calculator->getInvestmentPeriodTerm($startDate, $endDate);
        $this->assertEquals($expectedResult, $output);
    }
}
