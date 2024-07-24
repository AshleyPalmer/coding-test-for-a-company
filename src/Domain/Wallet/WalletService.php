<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use Exception;
use Money\Money;
use LendInvest\Domain\Wallet;

class WalletService
{
    public function __construct(
        private Wallet $wallet,
    ) {
    }

    public function deductFromWallet(Money $amount): Wallet
    {
        if ($this->hasBalanceToInvest($amount)) {
            $this->wallet->setAmount(
                $this->wallet->getAmount()->subtract($amount)
            );

            return $this->wallet;
        }
    }

    private function hasBalanceToInvest(Money $requestedAmount): bool
    {
        if ($requestedAmount->greaterThan($this->wallet->getAmount())) {
            throw new Exception("Not enough funds to invest", 400);
        }

        return true;
    }
}
