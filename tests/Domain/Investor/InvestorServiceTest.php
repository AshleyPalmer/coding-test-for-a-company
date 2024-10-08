<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Investor;

use DateTime;
use Money\Money;
use Money\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Investor\Investor;
use LendInvest\CodingTest\Domain\LoanPool\LoanPool;
use LendInvest\CodingTest\Domain\Investor\InvestorService;

class InvestorServiceTest extends TestCase
{
    protected Investor $investor1;
    protected Investor $investor2;
    protected Investor $investor3;
    protected Investor $investor4;
    protected Loan $loan;
    protected LoanPool $loanPool;

    public function setUp(): void
    {
        $this->investor1 = (new Investor('Investor 1'))->setWallet(new Wallet('100000'));
        $this->investor2 = (new Investor('Investor 2'))->setWallet(new Wallet('100000'));
        $this->investor3 = (new Investor('Investor 3'))->setWallet(new Wallet('100000'));
        $this->investor4 = (new Investor('Investor 4'))->setWallet(new Wallet('100000'));

        $this->loan = (new Loan(
            'loan',
            DateTime::createFromFormat('d/m/Y', '01/10/2023'),
            DateTime::createFromFormat('d/m/Y', '15/11/2023')
        ))->setTranches(
            [
                (new Tranche(Tranche::TRANCHE_A))
                    ->setInterestRate(3)
                    ->setAvailableInvestment(new Money('100000', new Currency('GBP'))),
                (new Tranche(Tranche::TRANCHE_B))
                    ->setInterestRate(6)
                    ->setAvailableInvestment(new Money('100000', new Currency('GBP'))),
            ]
        );

        $this->loanPool = new LoanPool([$this->loan]);
    }


    #[Test]
    public function test_can_create_investments(): void
    {
        $investorService = new InvestorService($this->investor1);
        $this->investor1 = $investorService->createInvestment(
            'Mock Investment',
            new Money('100000', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '03/10/2023'),
            Tranche::TRANCHE_A,
            $this->loan->getId(),
            $this->loanPool
        );

        $this->assertInstanceOf(Investor::class, $this->investor1);

        $investorService = new InvestorService($this->investor3);
        $this->investor3 = $investorService->createInvestment(
            'Mock Investment',
            new Money('50000', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '10/10/2023'),
            Tranche::TRANCHE_B,
            $this->loan->getId(),
            $this->loanPool
        );

        $mockZeroMoney = new Money('0', new Currency('GBP'));
        $mockHalfMoney = new Money('50000', new Currency('GBP'));

        $this->assertInstanceOf(Investor::class, $this->investor3);
        $this->assertEquals($mockZeroMoney, $this->investor1->getWallet()->getAmount());
        $this->assertEquals(
            $mockZeroMoney,
            $this->loan->getTrancheByName(Tranche::TRANCHE_A)->getAvailableInvestment()
        );

        $this->assertEquals($mockHalfMoney, $this->investor3->getWallet()->getAmount());
        $this->assertEquals(
            $mockHalfMoney,
            $this->loan->getTrancheByName(Tranche::TRANCHE_B)->getAvailableInvestment()
        );
    }

    #[Test]
    public function test_should_not_allow_excessive_investment(): void
    {
        $investorService = new InvestorService($this->investor1);
        $this->investor1 = $investorService->createInvestment(
            'Mock Investment',
            new Money('100000', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '03/10/2023'),
            Tranche::TRANCHE_A,
            $this->loan->getId(),
            $this->loanPool
        );

        $this->assertInstanceOf(Investor::class, $this->investor1);

        $investorService = new InvestorService($this->investor2);

        try {
            $this->investor2 = $investorService->createInvestment(
                'Mock Investment',
                new Money('100', new Currency('GBP')),
                DateTime::createFromFormat('d/m/Y', '04/10/2023'),
                Tranche::TRANCHE_A,
                $this->loan->getId(),
                $this->loanPool
            );
        } catch (InvalidArgumentException $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
        } finally {
            $this->assertInstanceOf(Investor::class, $this->investor2);
            $this->assertEquals(
                new Money('100000', new Currency('GBP')),
                $this->investor2->getWallet()->getAmount()
            );
            $this->assertEquals(
                new Money('0', new Currency('GBP')),
                $this->loan->getTrancheByName(Tranche::TRANCHE_A)->getAvailableInvestment()
            );
        }
    }

    #[Test]
    public function test_should_not_allow_negative_funds(): void
    {
        $investorService = new InvestorService($this->investor4);

        try {
            $this->investor4 = $investorService->createInvestment(
                'Mock Investment',
                new Money('110000', new Currency('GBP')),
                DateTime::createFromFormat('d/m/Y', '25/10/2023'),
                Tranche::TRANCHE_B,
                $this->loan->getId(),
                $this->loanPool
            );
        } catch (InvalidArgumentException $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
        } finally {
            $this->assertInstanceOf(Investor::class, $this->investor4);
            $this->assertEquals(
                new Money('100000', new Currency('GBP')),
                $this->investor4->getWallet()->getAmount()
            );
            $this->assertEquals(
                new Money('100000', new Currency('GBP')),
                $this->loan->getTrancheByName(Tranche::TRANCHE_B)->getAvailableInvestment()
            );
        }
    }
}
