<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\LoanPool;

use InvalidArgumentException;
use LendInvest\CodingTest\Domain\Loan\Loan;

class LoanPool
{
    protected ?array $loans;

    public function __construct(array $loans)
    {
        $this->loans = $loans;
    }

    public function getLoanById(string $id): Loan
    {
        /** @var Loan $loan */
        foreach ($this->loans as $loan) {
            if ($loan->getId() === $id) {
                return $loan;
            }
        }

        throw new InvalidArgumentException(
            sprintf('No Loan with the ID $s exists.', $id)
        );
    }

    /**
     * 
     */
    public function getLoans(): ?array
    {
        return $this->loans;
    }
}
