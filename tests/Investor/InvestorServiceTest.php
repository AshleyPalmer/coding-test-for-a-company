<?php

declare(strict_types=1);

use Money\Money;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Investor\Investor;
use LendInvest\CodingTest\Domain\LoanPool\LoanPool;
use PHPUnit\Framework\MockObject\Generator\MockType;
use LendInvest\CodingTest\Domain\Investment\Investment;
use LendInvest\CodingTest\Domain\Investor\InvestorService;

class InvestorServiceTest extends TestCase
{

    #[Test]
    public function test_can_create_investment()
    {
        $investor = (new Investor('Investor 1'))->setWallet(new Wallet('1000'));

        $loan = (new Loan(
            'loan',
            DateTime::createFromFormat('d/m/Y', '01/10/2023'),
            DateTime::createFromFormat('d/m/Y', '15/11/2023')
        ))->setTranches(
            [
                (new Tranche('A'))
                    ->setInterestRate(3)
                    ->setAvailableInvestment(new Money('1000', new Currency('GBP'))),
                (new Tranche('B'))
                    ->setInterestRate(6)
                    ->setAvailableInvestment(new Money('1000', new Currency('GBP'))),
            ]
        );

        $loanPool = new LoanPool([$loan]);

        $investorService = new InvestorService($investor);
        $investment = $investorService->createInvestment(
            new Money('1000', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '03/10/2023'),
            'A',
            $loan->getId(),
            $loanPool
        );

        $this->assertInstanceOf(Investment::class, $investment);
    }

    #[Test]
    public function test_should_not_allow_excessive_investment()
    {
        $investor1 = (new Investor('Investor 1'))->setWallet(new Wallet('1000'));
        $investor2 = (new Investor('Investor 2'))->setWallet(new Wallet('1000'));

        $loan = (new Loan(
            'loan',
            DateTime::createFromFormat('d/m/Y', '01/10/2023'),
            DateTime::createFromFormat('d/m/Y', '15/11/2023')
        ))->setTranches(
            [
                (new Tranche('A'))
                    ->setInterestRate(3)
                    ->setAvailableInvestment(new Money('1000', new Currency('GBP'))),
                (new Tranche('B'))
                    ->setInterestRate(6)
                    ->setAvailableInvestment(new Money('1000', new Currency('GBP'))),
            ]
        );

        $loanPool = new LoanPool([$loan]);

        $investorService = new InvestorService($investor1);
        $investment1 = $investorService->createInvestment(
            new Money('1000', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '03/10/2023'),
            'A',
            $loan->getId(),
            $loanPool
        );

        $this->assertInstanceOf(Investment::class, $investment1);

        $investorService = new InvestorService($investor2);

        $this->expectException(InvalidArgumentException::class);
        $investorService->createInvestment(
            new Money('1', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '04/10/2023'),
            'A',
            $loan->getId(),
            $loanPool
        );
    }

    #[Test]
    public function test_should_not_allow_negative_funds()
    {
        // Test
    }
}
