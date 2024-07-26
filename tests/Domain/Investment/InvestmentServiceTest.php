<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Investment;

use DateTime;
use Money\Money;
use Money\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Investment\Investment;
use LendInvest\CodingTest\Domain\Investment\InvestmentService;

class InvestmentServiceTest extends TestCase
{
    protected Investment $mockInvestment1;
    protected Investment $mockInvestment3;
    protected Loan $loan;

    protected function setUp(): void
    {
        $this->loan = (new Loan(
            'Mock Loan',
            DateTime::createFromFormat('d/m/Y', '01/10/2023'),
            DateTime::createFromFormat('d/m/Y', '15/11/2023')
        ))
            ->setTranches(
                [
                    (new Tranche(Tranche::TRANCHE_A))
                        ->setInterestRate(3)
                        ->setAvailableInvestment(new Money('100000', new Currency('GBP'))),
                    (new Tranche(Tranche::TRANCHE_B))
                        ->setInterestRate(6)
                        ->setAvailableInvestment(new Money('100000', new Currency('GBP'))),
                ]
            );

        $this->mockInvestment1 = (new Investment('mock', $this->loan))
            ->setinvestmentStartDate(
                DateTime::createFromFormat('d/m/Y', '03/10/2023')
            )
            ->setInvestedAmount(
                new Money('100000', new Currency('GBP'))
            )
            ->setTrancheName(Tranche::TRANCHE_A);

        $this->mockInvestment3 = (new Investment('mock', $this->loan))
            ->setinvestmentStartDate(
                DateTime::createFromFormat('d/m/Y', '10/10/2023')
            )
            ->setInvestedAmount(
                new Money('50000', new Currency('GBP'))
            )
            ->setTrancheName(Tranche::TRANCHE_B);
    }

    #[Test]
    public function test_can_calculate_earned_amount_for_period(): void
    {
        $investmentService = new InvestmentService($this->mockInvestment1);
        $result = $investmentService->getEarnedAmountForPeriod(DateTime::createFromFormat('d/m/Y', '31/10/2023'));

        $expectedAmount = new Money('2806', new Currency('GBP'));
        $this->assertEquals($expectedAmount, $result);

        $investmentService = new InvestmentService($this->mockInvestment3);
        $result = $investmentService->getEarnedAmountForPeriod(DateTime::createFromFormat('d/m/Y', '31/10/2023'));

        $expectedAmount = new Money('2129', new Currency('GBP'));
        $this->assertEquals($expectedAmount, $result);
    }

    #[Test]
    public function test_should_throw_exception_for_bad_tranche(): void
    {
        $mockInvestment = (new Investment('mock', $this->loan))
            ->setinvestmentStartDate(
                DateTime::createFromFormat('d/m/Y', '03/10/2023')
            )
            ->setInvestedAmount(
                new Money('100000', new Currency('GBP'))
            )
            ->setTrancheName('Bad Tranche Name');
        $investmentService = new InvestmentService($mockInvestment);

        $this->expectException(InvalidArgumentException::class);

        $investmentService->getEarnedAmountForPeriod(
            DateTime::createFromFormat('d/m/Y', '31/10/2023')
        );
    }
}
