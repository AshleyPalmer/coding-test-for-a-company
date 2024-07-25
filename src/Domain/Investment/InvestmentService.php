<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investment;

use DateTime;
use Money\Money;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Investment\Investment;
use LendInvest\CodingTest\Domain\Calculator\DateIntervalCalculator as IntervalCalc;
use LendInvest\CodingTest\Domain\Calculator\InterestRateCalculator as InterestCalc;
use LendInvest\CodingTest\Domain\Calculator\EarnedInterestCalculator as EarningsCalc;

class InvestmentService
{
    public function __construct(
        private Investment $investment,
    ) {
    }

    /**
     * Uses calculators and Investment object to retrieve the total earned amount
     * for a given period, from the investment start date
     * 
     * @param Datetime $endDate
     */
    public function getEarnedAmountForPeriod(DateTime $endDate): Money
    {
        $earnedForPeriod = EarningsCalc::getEarnedInterestAmount(
            $this->investment->getInvestedAmount(),
            $this->getPeriodInterestRate($endDate)
        );

        return $earnedForPeriod;
    }

    private function getPeriodInterestRate(DateTime $endDate): int|float
    {
        $dailyInterestRate = InterestCalc::getDailyInterestRate(
            $this->getInvestedTranche()->getInterestRate(),
            $endDate
        );

        $daysInvested = IntervalCalc::getInvestmentPeriodTerm(
            $this->investment->getInvestmentStartDate(),
            $endDate
        );

        return InterestCalc::getInvestedPeriodInterestRate(
            $dailyInterestRate,
            $daysInvested
        );
    }

    /**
     * Gets Invested Tranche
     * 
     * @return Tranche
     */
    private function getInvestedTranche(): Tranche
    {
        return $this->investment->getLoan()
            ->getTrancheByName(
                $this->investment->getTrancheName()
            );
    }
}
