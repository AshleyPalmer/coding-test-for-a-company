<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Tranche;

use Money\Money;
use Money\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Tranche\TrancheService;

class TrancheServiceTest extends TestCase
{
    protected Tranche $tranche;

    public function setUp(): void
    {
        $this->tranche = (new Tranche('Tranche'))
            ->setInterestRate(3)
            ->setAvailableInvestment(
                new Money('100000', new Currency('GBP'))
            );
    }

    #[Test]
    public function test_check_can_invest_successfully(): void
    {
        $requestAmount = new Money('50000', new Currency('GBP'));
        $trancheService = new TrancheService($this->tranche);
        $this->assertTrue($trancheService->hasAmountToInvest($requestAmount));
    }

    #[Test]
    public function test_check_can_not_invest(): void
    {
        $requestAmount = new Money('110000', new Currency('GBP'));
        $trancheService = new TrancheService($this->tranche);
        $this->expectException(InvalidArgumentException::class);
        $trancheService->hasAmountToInvest($requestAmount);
    }

    #[Test]
    public function test_deduct_from_tranche(): void
    {
        $requestAmount = new Money('50000', new Currency('GBP'));
        $trancheService = new TrancheService($this->tranche);
        $this->tranche = $trancheService->deductFromTranche($requestAmount);
        $this->assertEquals($requestAmount, $this->tranche->getAvailableInvestment());
    }
}
