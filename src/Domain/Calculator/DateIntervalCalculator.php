<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Calculator;

use DateTime;

class DateIntervalCalculator
{

    /**
     * Calculate the length of time invested in days
     * 
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return int
     */
    public function getInvestmentPeriodTerm(DateTime $startDate, DateTime $endDate): int
    {
        /**
         * diff sum includes the start date but not the end date,
         * so add a day onto the end date to include it in the sum.
         */
        $endDate->modify('+1 day');

        return (int) $startDate->diff($endDate)->format('%a');
    }
}
