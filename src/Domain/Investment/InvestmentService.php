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
    protected DateIntervalCalculator $dateIntervalCalculator;
    protected InterestRateCalculator $interestRateCalculator;
    protected EarnedInterestCalculator $earnedInterestCalculator;

    public function __construct(
        private Investment $investment,
    ) {
        $this->dateIntervalCalculator = new DateIntervalCalculator();
        $this->interestRateCalculator = new InterestRateCalculator();
        $this->earnedInterestCalculator = new EarnedInterestCalculator();
    }

    /**
     * Uses calculators and Investment object to retrieve the total earned amount
     * for a given period, from the investment start date
     *
     * @param Datetime $endDate
     * @return Money
     */
    public function getEarnedAmountForPeriod(DateTime $endDate): Money
    {
        $earnedForPeriod = $this->earnedInterestCalculator->getEarnedInterestAmount(
            $this->investment->getInvestedAmount(),
            $this->getPeriodInterestRate($endDate)
        );

        return $earnedForPeriod;
    }

    /**
     * Calculate Interest Rate for a given month
     * Just requires last day of the month, or any date -
     * uses DateTime to count total days of given month.
     *
     * @param DateTime $endDate
     * @return int|float
     */
    private function getPeriodInterestRate(DateTime $endDate): int|float
    {
        $dailyInterestRate = $this->interestRateCalculator->getDailyInterestRate(
            $this->getInvestedTranche()->getInterestRate(),
            $endDate
        );

        $daysInvested = $this->dateIntervalCalculator->getInvestmentPeriodTerm(
            $this->investment->getInvestmentStartDate(),
            $endDate
        );

        return $this->interestRateCalculator->getInvestedPeriodInterestRate(
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
