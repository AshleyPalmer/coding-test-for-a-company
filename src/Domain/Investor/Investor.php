<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investor;

use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Investment\Investment;

class Investor
{
    protected string $investorName;
    protected Wallet $wallet;
    protected ?array $investments;

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
     * @param string $investorName
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
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * Set Investor's Wallet
     * 
     * @param Wallet $wallet
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
     * Set Investors Investments
     * 
     * @param Array|Investment[]|null $investments
     * @return Investor
     */
    public function setInvestments($investments): self
    {
        $this->investments = $investments;

        return $this;
    }
}
