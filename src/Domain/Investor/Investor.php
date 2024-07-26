<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investor;

use InvalidArgumentException;
use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Investment\Investment;

class Investor
{
    protected string $investorName;
    protected ?Wallet $wallet = null;
    protected ?array $investments = [];

    public function __construct(
        string $investorName,
    ) {
        $this->investorName = $investorName;
    }

    /**
     * Get Investor Name
     *
     * @return string
     */
    public function getInvestorName(): string
    {
        return $this->investorName;
    }

    /**
     * Set Investor Name
     *
     * @param  string $investorName
     * @return Investor
     */
    public function setInvestorName(string $investorName): self
    {
        $this->investorName = $investorName;

        return $this;
    }

    /**
     * Get Investor's Wallet
     *
     * @return Wallet|null
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * Set Investor's Wallet
     *
     * @param  Wallet $wallet
     * @return Investor
     */
    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Get Investor Investments
     *
     * @return array|Investment[]|null
     */
    public function getInvestments(): ?array
    {
        return $this->investments;
    }

    /**
     * Get Investment By ID
     *
     * @param string $id
     * @return Investment
     */
    public function getInvestmentById(string $id): Investment
    {
        /** @var Investment $investment */
        foreach ($this->investments as $investment) {
            if ($investment->getId() === $id) {
                return $investment;
            }
        }

        throw new InvalidArgumentException(sprintf('No Investment exists with the ID %s.', $id));
    }

    /**
     * Set Investors Investments
     *
     * @param  Array|Investment[]|null $investments
     * @return Investor
     */
    public function setInvestments(?array $investments): self
    {
        $this->investments = $investments;

        return $this;
    }
}
