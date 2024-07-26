<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Loan;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Tranche\Tranche;

class LoanTest extends TestCase
{

    #[Test]
    public function test_can_create_a_new_loan(): void
    {
        $loan = new Loan(
            'Loan',
            new DateTime('yesterday'),
            new DateTime('tomorrow')
        );

        $this->assertInstanceOf(Loan::class, $loan);
    }

    #[Test]
    public function test_loan_can_set_tranches(): void
    {
        $loan = new Loan(
            'Loan',
            new DateTime('yesterday'),
            new DateTime('tomorrow')
        );

        $loan->setTranches([
            new Tranche('Test Tranche')
        ]);

        $this->assertContainsOnlyInstancesOf(Tranche::class, $loan->getTranches());
    }

    #[Test]
    public function test_can_find_tranche_by_name(): void
    {
        $loan = (new Loan(
            'Loan',
            new DateTime('yesterday'),
            new DateTime('tomorrow')
        ))
            ->setTranches(
                [
                    new Tranche('First Tranche'),
                    new Tranche('Second Tranche'),
                    new Tranche('Third Tranche')
                ]
            );

        $result = $loan->getTrancheByName('Second Tranche');
        $this->assertInstanceOf(Tranche::class, $result);
        $this->assertEquals('Second Tranche', $result->getName());
    }

    #[Test]
    public function test_throw_bad_tranche_name_search(): void
    {
        $loan = (new Loan(
            'Loan',
            new DateTime('yesterday'),
            new DateTime('tomorrow')
        ))
            ->setTranches(
                [
                    new Tranche('First Tranche'),
                    new Tranche('Second Tranche'),
                    new Tranche('Third Tranche')
                ]
            );

        $this->expectException(InvalidArgumentException::class);
        $loan->getTrancheByName('Fourth Tranche');
    }
}
