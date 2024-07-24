<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use DateTime;
use Money\Money;
use LendInvest\Domain\Investment;
use LendInvest\Domain\DateIntervalCalculator;
use LendInvest\Domain\InterestRateCalculator;
use LendInvest\Domain\EarnedInterestCalculator;

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
        $daysInvested = $this->intervalCalc->getInvestmentPeriodTerm(
            $this->investment->getStartDate(),
            $endDate
        );

        $dailyInterestRate = $this->interestCalc->getDailyInterestRate(
            $this->getInvestedTranche()->getInterestRate(),
            $endDate
        );

        $earnedForPeriod = $this->earningsCalc->getEarnedInterestAmount(
            $this->investment->getInvestedAmount(),
            $dailyInterestRate
        );

        return $earnedForPeriod;
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
