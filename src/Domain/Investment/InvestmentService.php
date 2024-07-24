<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investment;

use DateTime;
use Money\Money;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Investment\Investment;
use LendInvest\CodingTest\Domain\Calculator\DateIntervalCalculator;
use LendInvest\CodingTest\Domain\Calculator\InterestRateCalculator;
use LendInvest\CodingTest\Domain\Calculator\EarnedInterestCalculator;

class InvestmentService
{
    public function __construct(
        private Investment $investment,
        private DateIntervalCalculator $intervalCalc,
        private InterestRateCalculator $interestCalc,
        private EarnedInterestCalculator $earningsCalc
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
        $earnedForPeriod = $this->earningsCalc->getEarnedInterestAmount(
            $this->investment->getInvestedAmount(),
            $this->getPeriodInterestRate($endDate)
        );

        return $earnedForPeriod;
    }

    private function getPeriodInterestRate(DateTime $endDate): int|float
    {
        $dailyInterestRate = $this->interestCalc->getDailyInterestRate(
            $this->getInvestedTranche()->getInterestRate(),
            $endDate
        );

        $daysInvested = $this->intervalCalc->getInvestmentPeriodTerm(
            $this->investment->getStartDate(),
            $endDate
        );

        return $this->interestCalc->getInvestedPeriodInterestRate(
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
