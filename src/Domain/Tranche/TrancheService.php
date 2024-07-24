<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Tranche;

use Money\Money;
use InvalidArgumentException;
use LendInvest\CodingTest\Domain\Tranche\Tranche;

class TrancheService
{
    public function __construct(
        private Tranche $tranche
    ) {
    }

    public function deductFromTranche(Money $amount): Tranche
    {
        $this->tranche->setAvailableInvestment(
            $this->tranche->getAvailableInvestment()->subtract($amount)
        );

        return $this->tranche;
    }

    public function hasAmountToInvest(Money $requestedAmount): bool
    {
        if ($requestedAmount->greaterThan($this->tranche->getAvailableInvestment())) {
            throw new InvalidArgumentException("Not enough available capacity to invest in this tranche", 400);
        }

        return true;
    }
}
