<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use Exception;
use Money\Money;
use LendInvest\Domain\Tranche;

class TrancheService
{
    public function __construct(
        private Tranche $tranche,
    ) {
    }

    public function deductFromTranche(Money $amount): Tranche
    {
        if ($this->hasAmountToInvest($amount)) {
            $this->tranche->setAvailableInvestment(
                $this->tranche->getAvailableInvestment()->subtract($amount)
            );
        }

        return $this->tranche;
    }

    private function hasAmountToInvest(Money $requestedAmount): bool
    {
        if ($requestedAmount->greaterThan($this->tranche->getAvailableInvestment())) {
            throw new Exception("Not enough available capacity to invest in this tranche", 400);
        }

        return true;
    }
}
