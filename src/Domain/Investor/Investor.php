<?php

namespace LendInvest\Domain;

use LendInvest\Domain\Wallet;
use LendInvest\Domain\Investment;

class Investor
{
    protected int $id;
    protected string $investorName;
    protected Wallet $wallet;
    protected ?array $investments;

    public function __construct(
        int $id,
        string $investorName,
        Wallet $wallet
    ) {
        $this->id = $id;
        $this->investorName = $investorName;
        $this->wallet = $wallet;
    }

    /**
     * Get Investor ID
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set Investor ID
     * @param int $id
     * @return Investor
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get Investor Name
     * @return string
     */
    public function getInvestorName(): string
    {
        return $this->investorName;
    }

    /**
     * Set Investor Name
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
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * Set Investor's Wallet
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
     * @return array|Investment[]|null
     */
    public function getInvestments(): ?array
    {
        return $this->investments;
    }

    /**
     * Set Investors Investments
     * @param Array|Investment[]|null $investments
     * @return Investor
     */
    public function setInvestments($investments): self
    {
        $this->investments = $investments;

        return $this;
    }
}
