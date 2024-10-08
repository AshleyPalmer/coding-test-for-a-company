<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investment;

use DateTime;
use Money\Money;
use LendInvest\CodingTest\Domain\Loan\Loan;

class Investment
{
    protected string $id;
    protected Loan $loan;
    protected ?string $trancheName = null;
    protected ?DateTime $investmentStartDate = null;
    protected ?Money $investedAmount = null;

    public function __construct(string $id, Loan $loan)
    {
        $this->id = $id;
        $this->loan = $loan;
    }

    /**
     * Get Investment ID
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get Investment Start Date
     *
     * @return DateTime|null $startDate
     */
    public function getInvestmentStartDate(): ?DateTime
    {
        return $this->investmentStartDate;
    }

    /**
     * Get Investment Start Date
     *
     * @param  Datetime $startDate
     * @return Investment
     */
    public function setInvestmentStartDate(DateTime $startDate): self
    {
        $this->investmentStartDate = $startDate;

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
     * @return string|null
     */
    public function getTrancheName(): ?string
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
     * Get Invested Amount
     *
     * @return Money|null
     */
    public function getInvestedAmount(): ?Money
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
