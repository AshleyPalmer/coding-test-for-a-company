<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Investor\Investor;
use LendInvest\CodingTest\Domain\Investment\Investment;

class InvestorTest extends TestCase
{
    protected string $investorName;

    protected function setUp(): void
    {
        $this->investorName = 'Test Investor';
    }


    #[Test]
    public function test_investor_can_be_created(): Investor
    {
        $investor = new Investor($this->investorName);

        $this->assertInstanceOf(Investor::class, $investor);
        $this->assertSame($this->investorName, $investor->getInvestorName());

        return $investor;
    }

    #[Depends('test_investor_can_be_created')]
    public function test_can_add_new_wallet(Investor $investor)
    {
        $mockWallet = new Wallet('100000');
        $investor->setWallet($mockWallet);

        $this->assertEquals($mockWallet, $investor->getWallet());
    }

    #[Depends('test_investor_can_be_created')]
    public function test_can_change_investor_name(Investor $investor)
    {
        $this->assertEquals($this->investorName, $investor->getInvestorName());
        $investor->setInvestorName('New Investor');
        $this->assertEquals('New Investor', $investor->getInvestorName());
    }

    #[Depends('test_investor_can_be_created')]
    public function test_can_add_new_investment(Investor $investor)
    {
        $investor->setInvestments(
            [
                new Investment(new Loan(
                    'loan',
                    DateTime::createFromFormat('d/m/Y', '01/10/2023'),
                    DateTime::createFromFormat('d/m/Y', '15/11/2023')
                )),
                new Investment(new Loan(
                    'loan two',
                    DateTime::createFromFormat('d/m/Y', '13/10/2023'),
                    DateTime::createFromFormat('d/m/Y', '20/11/2023')
                ))
            ]
        );

        $this->assertContainsOnlyInstancesOf(Investment::class, $investor->getInvestments());
    }
}
