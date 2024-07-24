<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use LendInvest\Domain\Investor;
use LendInvest\Domain\WalletService;
use LendInvest\Domain\TrancheService;

class InvestorService
{
    public function __construct(
        private Investor $investor,
        private WalletService $walletService,
        private TrancheService $trancheService
    ) {
    }

    public function createInvestment()
    {
        /**
         * TODO: 
         * 1. Check existing balance in wallet, and requested investment size
         * 2. Check Loan Tranche has available amount for requested investment size
         * 3. Create the investment
         */
    }
}
