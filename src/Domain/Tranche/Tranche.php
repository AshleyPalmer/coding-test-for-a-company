<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Tranche;

use Money\Money;

class Tranche
{
    public const TRANCHE_A = 'A';
    public const TRANCHE_B = 'B';

    protected string $name;
    protected ?int $interestRate = null;
    protected ?Money $availableInvestment = null;

    public function __construct(
        string $name,
    ) {
        $this->name = $name;
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
     * Get Tranche Interest Rate
     *
     * @return int|null
     */
    public function getInterestRate(): ?int
    {
        return $this->interestRate;
    }

    /**
     * Set Tranche Interest Rate
     *
     * @param  int $interestRate
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
     * @return Money|null
     */
    public function getAvailableInvestment(): ?Money
    {
        return $this->availableInvestment;
    }

    /**
     * Set Available Investment Amount
     *
     * @param  Money $amount
     * @return Tranche
     */
    public function setAvailableInvestment(Money $amount): self
    {
        $this->availableInvestment = $amount;

        return $this;
    }
}
