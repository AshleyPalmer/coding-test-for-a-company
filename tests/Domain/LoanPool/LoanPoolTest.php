<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\LoanPool;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\LoanPool\LoanPool;

class LoanPoolTest extends TestCase
{
    #[Test]
    public function test_can_create_a_new_loan_pool(): void
    {
        $loan = new Loan('Loan', new DateTime('today'), new DateTime('tomorrow'));
        $loanPool = new LoanPool([$loan]);

        $this->assertInstanceOf(LoanPool::class, $loanPool);
    }

    #[Test]
    public function test_can_get_loan_by_id(): void
    {
        $needle = new Loan('Another Loan', new DateTime('today'), new DateTime('tomorrow'));

        $loanPool = new LoanPool(
            [
                new Loan('Loan', new DateTime('today'), new DateTime('tomorrow')),
                new Loan('Another Loan', new DateTime('today'), new DateTime('tomorrow')),
                new Loan('Last Loan', new DateTime('today'), new DateTime('tomorrow')),
            ]
        );

        $fetchedLoan = $loanPool->getLoanById('Another Loan');

        $this->assertEquals($needle, $fetchedLoan);
    }

    #[Test]
    public function test_should_throw_from_bad_loan_id(): void
    {
        $loanPool = new LoanPool(
            [
                new Loan('Loan', new DateTime('today'), new DateTime('tomorrow')),
                new Loan('Last Loan', new DateTime('today'), new DateTime('tomorrow')),
            ]
        );

        $this->expectException(InvalidArgumentException::class);
        $loanPool->getLoanById('Another Loan');
    }
}
