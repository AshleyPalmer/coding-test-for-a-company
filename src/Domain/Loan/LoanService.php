<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use LendInvest\Domain\Loan;

class LoanService
{
    public function __construct(
        private Loan $loan,
    ) {
    }
}
