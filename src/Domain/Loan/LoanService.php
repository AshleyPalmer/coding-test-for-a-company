<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Loan;

use Exception;
use Money\Money;
use InvalidArgumentException;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Tranche\Tranche;

class LoanService
{
    public function __construct(
        private Loan $loan
    ) {
    }

    /**
     * Creates and adds a new Tranche to the Loan
     * 
     * Note: this isn't used in the unit tests, because the loans 
     * and tranches are mocked rather than built through the service functions..
     * But it is used in the bin/Tests.php functions
     * 
     * @param  string $name
     * @param  int    $interestRate
     * @param  Money  $availableInvestment
     * @return Loan
     */
    public function createTranche(
        string $name,
        int $interestRate,
        Money $availableInvestment
    ): Loan {
        try {
            if ($this->loan->getTrancheByName($name)) {
                throw new Exception("Tranche already exists with this name");
            }
        } catch (InvalidArgumentException $e) {
            //No Tranches exist already with this name, carry on
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $loanTranches = $this->loan->getTranches();
        $tranche = (new Tranche($name))
            ->setInterestRate($interestRate)
            ->setAvailableInvestment($availableInvestment);

        array_push($loanTranches, $tranche);
        $this->loan->setTranches($loanTranches);

        return $this->loan;
    }
}
