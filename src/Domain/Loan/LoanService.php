<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use Money\Money;
use LendInvest\Domain\Loan;

class LoanService
{
    public function __construct(
        private Loan $loan,
    ) {
    }

    /**
     * Creates and adds a new Tranche to the Loan
     * 
     * @param string $name
     * @param int $interestRate
     * @param Money $availableInvestment
     * @return Loan
     */
    public function createTranche(
        string $name,
        int $interestRate,
        Money $availableInvestment
    ): Loan {
        $loanTranches = $this->loan->getTranches();
        $tranche = new Tranche($name, $interestRate, $availableInvestment);

        $combinedTranches = array_combine(
            array_map(fn (Tranche $tranche) => $tranche->getName(), $loanTranches),
            $loanTranches
        );

        $this->loan->setTranches($combinedTranches);

        return $this->loan;
    }
}
