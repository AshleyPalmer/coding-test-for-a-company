<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Loan;

use DateTime;
use Money\Money;
use Money\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Loan\LoanService;

class LoanServiceTest extends TestCase
{
    protected Loan $loan;

    public function setUp(): void
    {
        $this->loan = new Loan(
            'Loan',
            DateTime::createFromFormat('d/m/Y', '01/10/2023'),
            DateTime::createFromFormat('d/m/Y', '15/11/2023')
        );
    }

    #[Test]
    public function test_can_create_tranche(): void
    {
        $loanService = new LoanService($this->loan);
        $this->loan = $loanService->createTranche(
            Tranche::TRANCHE_A,
            3,
            new Money('100000', new Currency('GBP'))
        );

        $this->assertInstanceOf(Tranche::class, $this->loan->getTrancheByName(Tranche::TRANCHE_A));
        $this->assertEquals(
            new Money(
                '100000',
                new Currency('GBP')
            ),
            $this->loan->getTrancheByName(Tranche::TRANCHE_A)->getAvailableInvestment()
        );
    }

    #[Test]
    public function test_can_not_create_duplicate_tranches(): void
    {
        $loanService = new LoanService($this->loan);
        $this->loan = $loanService->createTranche(
            Tranche::TRANCHE_A,
            3,
            new Money('100000', new Currency('GBP'))
        );

        $this->assertContainsOnlyInstancesOf(Tranche::class, $this->loan->getTranches());

        $this->expectException(InvalidArgumentException::class);

        $this->loan = $loanService->createTranche(
            Tranche::TRANCHE_A,
            3,
            new Money('100000', new Currency('GBP'))
        );
    }
}
