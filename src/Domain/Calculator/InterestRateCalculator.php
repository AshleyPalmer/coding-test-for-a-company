<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Calculator;

use DateTime;

class InterestRateCalculator
{
    /**
     * Calculate the daily interest rate
     *
     * @param  int|float $interestRate
     * @param  DateTime  $inputDate
     * @return int|float
     */
    public static function getDailyInterestRate(int|float $interestRate, DateTime $inputDate): float|int
    {
        //Gets the number of days from the provided DateTime object
        $daysInMonth = (int)$inputDate->format('t');

        return ($interestRate / $daysInMonth);
    }

    /**
     * Calculate the interest rate for a period of days invested
     *
     * @param  int|float $dailyInterestRate
     * @param  int       $daysInvested
     * @return int|float
     */
    public static function getInvestedPeriodInterestRate(int|float $dailyInterestRate, int $daysInvested)
    {
        return ($dailyInterestRate * $daysInvested);
    }
}
