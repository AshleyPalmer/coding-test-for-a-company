<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use Money\Money;
use LendInvest\Domain\Wallet;

class WalletService
{
    public function __construct(
        private Wallet $wallet,
    ) {
    }

    public function hasBalanceToInvest(Money $requestedAmount)
    {
        //TODO: Compare amounts, return true if good else throw an exception
    }

    public function deductFromWallet(Money $amount)
    {
        //TODO: implement
    }
}
