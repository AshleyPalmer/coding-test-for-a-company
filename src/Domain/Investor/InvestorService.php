<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investor;

use DateTime;
use Throwable;
use Money\Money;
use LendInvest\CodingTest\Domain\Investor\Investor;
use LendInvest\CodingTest\Domain\LoanPool\LoanPool;
use LendInvest\CodingTest\Domain\Wallet\WalletService;
use LendInvest\CodingTest\Domain\Investment\Investment;
use LendInvest\CodingTest\Domain\Tranche\TrancheService;

class InvestorService
{
    public function __construct(
        private Investor $investor,
    ) {
    }

    /**
     * Create a new Investment object
     * 
     * @param Money    $amount
     * @param Datetime $investDate
     * @param string   $trancheName
     * @param string   $loanId
     * @param LoanPool $loanPool
     * 
     * @return Investment
     */
    public function createInvestment(
        Money $amount,
        DateTime $investDate,
        string $trancheName,
        string $loanId,
        LoanPool $loanPool,
    ): Investment {
        $walletService = new WalletService($this->investor->getWallet());

        try {
            $loan = $loanPool->getLoanById($loanId);
            $tranche = $loan->getTrancheByName($trancheName);
            $trancheService = new TrancheService($tranche);

            //Validation check the tranche and wallet 
            //to make sure both have enough capacity to be invested
            if (
                $trancheService->hasAmountToInvest($amount)
                && $walletService->hasBalanceToInvest($amount)
            ) {
                $trancheService->deductFromTranche($amount);
                $walletService->deductFromWallet($amount);

                $investment = (new Investment($loan))
                    ->setStartDate($investDate)
                    ->setTrancheName($tranche->getName())
                    ->setInvestedAmount($amount);

                return $investment;
            }
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
