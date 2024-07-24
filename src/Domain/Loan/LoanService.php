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
            echo $e->getMessage();
            exit;
        }

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
