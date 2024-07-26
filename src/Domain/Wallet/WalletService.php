<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Wallet;

use Money\Money;
use InvalidArgumentException;
use LendInvest\CodingTest\Domain\Wallet\Wallet;

class WalletService
{
    public function __construct(
        private Wallet $wallet
    ) {
        $this->wallet = $wallet;
    }

    /**
     * Reduces Wallet amount
     *
     * @param Money $amount
     * @return Wallet
     */
    public function deductFromWallet(Money $amount): Wallet
    {
        $this->wallet->setAmount(
            $this->wallet->getAmount()->subtract($amount)
        );

        return $this->wallet;
    }

    /**
     * Validation to check Wallet has enough money for investment
     *
     * @param Money $requestedAmount
     * @return bool
     * @throws InvalidArgumentException
     */
    public function hasBalanceToInvest(Money $requestedAmount): bool
    {
        if ($requestedAmount->greaterThan($this->wallet->getAmount())) {
            throw new InvalidArgumentException("Not enough funds to invest", 400);
        }

        return true;
    }
}
