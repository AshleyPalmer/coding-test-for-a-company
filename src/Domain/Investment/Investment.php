<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use DateTime;
use LendInvest\Domain\Loan;

class Investment extends Loan
{
    protected Loan $loan;
    protected string $trancheName;
    protected DateTime $startDate;

    public function __construct(Loan $loan, string $trancheName, DateTime|null $startDate)
    {
        parent::__construct(
            $loan->id,
            $loan->startDate,
            $loan->endDate,
            $loan->tranches
        );

        $this->startDate = $startDate ?: new DateTime('now');
        $this->trancheName = $trancheName;
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
     * @param Datetime $startDate
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
     * @param string $trancheName
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
}
