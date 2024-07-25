<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Investor;

use DateTime;
use Money\Money;
use InvalidArgumentException;
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
     * @param string $id
     * @param Money    $amount
     * @param Datetime $investDate
     * @param string   $trancheName
     * @param string   $loanId
     * @param LoanPool $loanPool
     *
     * @return Investor
     */
    public function createInvestment(
        string $id,
        Money $amount,
        DateTime $investDate,
        string $trancheName,
        string $loanId,
        LoanPool $loanPool,
    ): Investor {
        $walletService = new WalletService($this->investor->getWallet());

        try {
            //find loan from 'loan database' class
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

                $investment = (new Investment($id, $loan))
                    ->setinvestmentStartDate($investDate)
                    ->setTrancheName($tranche->getName())
                    ->setInvestedAmount($amount);

                $this->investor->setInvestments(
                    $this->updateInvestments($investment)
                );

                return $this->investor;
            }
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * Appends a new investment to the Investors existing investments
     *
     * @param Investment $newInvestment
     * @return array|Investment[]
     */
    private function updateInvestments(
        Investment $newInvestment
    ): array {
        $existingInvestments = $this->investor->getInvestments();
        array_push($existingInvestments, $newInvestment);

        return $existingInvestments;
    }
}
