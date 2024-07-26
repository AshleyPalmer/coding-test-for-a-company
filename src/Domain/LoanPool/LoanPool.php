<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\LoanPool;

use InvalidArgumentException;
use LendInvest\CodingTest\Domain\Loan\Loan;

/**
 * The purpose of this class is to sort of
 * act as a database table for the loans
 */
class LoanPool
{
    protected ?array $loans;

    public function __construct(array $loans)
    {
        $this->loans = $loans;
    }

    /**
     * Get Loan by ID
     * 
     * @param string $id
     * @return Loan
     * @throws InvalidArgumentException
     */
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
     * Get all Loans
     * 
     * @return array|Loan[]|null
     */
    public function getLoans(): ?array
    {
        return $this->loans;
    }
}
