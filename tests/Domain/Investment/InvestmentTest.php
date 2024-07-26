<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Investment;

use DateTime;
use Money\Money;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Investment\Investment;

class InvestmentTest extends TestCase
{

    protected Loan $loan;
    protected Money $amount;

    protected function setUp(): void
    {
        $this->loan = new Loan(
            'loan',
            DateTime::createFromFormat('d/m/Y', '01/10/2023'),
            DateTime::createFromFormat('d/m/Y', '15/11/2023')
        );

        $this->amount = new Money('100000', new Currency('GBP'));
    }


    #[Test]
    public function test_investment_can_be_created(): Investment
    {
        $investment = (new Investment('mock', $this->loan))
            ->setInvestedAmount(new Money('100000', new Currency('GBP')))
            ->setinvestmentStartDate(new DateTime('today'))
            ->setTrancheName('Mock Tranche');

        $this->assertInstanceOf(Investment::class, $investment);
        $this->assertEquals($this->loan, $investment->getLoan());

        return $investment;
    }

    #[Depends('test_investment_can_be_created')]
    public function test_can_set_investment_params(Investment $investment)
    {
        $investment
            ->setInvestedAmount(new Money('100000', new Currency('GBP')))
            ->setinvestmentStartDate(new DateTime('today'))
            ->setTrancheName('Mock Tranche');

        $this->assertEquals('100000', $investment->getInvestedAmount()->getAmount());
        $this->assertInstanceOf(DateTime::class, $investment->getInvestmentStartDate());
        $this->assertEquals('Mock Tranche', $investment->getTrancheName());
    }
}
