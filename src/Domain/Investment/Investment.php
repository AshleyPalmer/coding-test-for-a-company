<?php

namespace LendInvest\Domain;

use DateTime;
use LendInvest\Domain\Loan;

class Investment
{
    protected Loan $loan;
    protected DateTime $startDate;
    protected int $duration;

    public function __construct(Loan $loan, DateTime|null $startDate)
    {
        $this->loan = $loan;
        $this->startDate = $startDate ?: new DateTime('now');
    }

    /**
     * Get Loan
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * Set Loan
     * @param Loan $loan
     * @return Investment
     */
    public function setLoan(Loan $loan): self
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get Investment Start Date
     * @return DateTime $startDate
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * Get Investment Start Date
     * @param Datetime $startDate
     * @return Investment
     */
    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }
}
