<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Wallet;

use Money\Currency;
use Money\Money as Money;

class Wallet
{
    protected Money $amount;

    public function __construct(string $amount)
    {
        $this->amount = new Money($amount, new Currency('GBP'));
    }

    /**
     * Get Wallet Amount
     *
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * Set Wallet Amount
     *
     * @param  Money $amount
     * @return Wallet
     */
    public function setAmount(Money $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Returns Wallet Amount as a Money JSON object
     *
     * @return array
     */
    public function getAmountJson(): array
    {
        return $this->amount->jsonSerialize();
    }
}
