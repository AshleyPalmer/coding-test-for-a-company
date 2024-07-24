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
        if (isset($this->loans[$id])) {
            return $this->loans[$id];
        }

        throw new InvalidArgumentException(
            sprintf('No Loan with the ID $d exists.', $id)
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
