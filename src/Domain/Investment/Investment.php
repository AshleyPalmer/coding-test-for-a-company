<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investment;

use DateTime;
use Money\Money;
use LendInvest\CodingTest\Domain\Loan\Loan;

class Investment extends Loan
{
    protected Loan $loan;
    protected string $trancheName;
    protected DateTime $startDate;
    protected Money $investedAmount;

    public function __construct(Loan $loan)
    {
        parent::__construct($loan->id, $loan->startDate, $loan->endDate);
    }

    /**
     * Get Investment Start Date
     * 
     * @return DateTime $startDate
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * Get Investment Start Date
     * 
     * @param  Datetime $startDate
     * @return Investment
     */
    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Set Invested Tranche Name
     * 
     * @param  string $trancheName
     * @return Investment
     */
    public function setTrancheName(string $trancheName): self
    {
        $this->trancheName = $trancheName;

        return $this;
    }

    /**
     * Get Invested Tranche Name
     * 
     * @return string
     */
    public function getTrancheName(): string
    {
        return $this->trancheName;
    }

    /**
     * Get Investment Loan
     * 
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * Set Investment Loan
     * 
     * @param  Loan $loan
     * @return Investment
     */
    public function setLoan(Loan $loan): self
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get Invested Amount
     * 
     * @return Money
     */
    public function getInvestedAmount(): Money
    {
        return $this->investedAmount;
    }

    /**
     * Set Invested Amount
     * 
     * @param  Money $amount
     * @return Investment
     */
    public function setInvestedAmount(Money $amount): self
    {
        $this->investedAmount = $amount;

        return $this;
    }
}
