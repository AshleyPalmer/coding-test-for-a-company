<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use Money\Money;

class Tranche
{
    protected string $name;
    protected int $interestRate;
    protected Money $availableInvestment;

    public function __construct(
        string $name,
        int $interestRate,
        Money $availableInvestment
    ) {
        $this->name = $name;
        $this->interestRate = $interestRate;
        $this->availableInvestment = $availableInvestment;
    }

    /**
     * Get Tranche Name
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Tranche Name
     * 
     * @param string $name
     * @return Tranche
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Tranche Interest Rate
     * 
     * @return int
     */
    public function getInterestRate(): int
    {
        return $this->interestRate;
    }

    /**
     * Set Tranche Interest Rate
     * 
     * @param int $interestRate
     * @return Tranche
     */
    public function setInterestRate(int $interestRate): self
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    /**
     * Get Available Investment Amount
     * 
     * @return Money
     */
    public function getAvailableInvestment(): Money
    {
        return $this->availableInvestment;
    }

    /**
     * Set Available Investment Amount
     * 
     * @param Money $amount
     * @return Tranche
     */
    public function setAvailableInvestment(Money $amount): self
    {
        $this->availableInvestment = $amount;

        return $this;
    }
}
