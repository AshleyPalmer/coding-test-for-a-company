<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use Money\Money;
use LendInvest\Domain\Tranche;

class TrancheService
{
    public function __construct(
        private Tranche $tranche,
    ) {
    }

    public function deductFromTranche(Money $amount)
    {
        //TODO: implement
    }
}
