<?php

declare(strict_types=1);

namespace Tests\LendInvest\CodingTest\Domain\Tranche;

use Money\Money;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Tranche\Tranche;

class TrancheTest extends TestCase
{

    #[Test]
    public function test_can_create_a_new_tranche(): void
    {
        $tranche = new Tranche('A');

        $this->assertInstanceOf(Tranche::class, $tranche);
    }

    #[Test]
    public function test_tranche_can_set_variables(): void
    {
        $tranche = new Tranche('A');
        $tranche->setInterestRate(3);
        $tranche->setAvailableInvestment(new Money('100000', new Currency('GBP')));

        $money = new Money('100000', new Currency('GBP'));

        $this->assertObjectEquals($money, $tranche->getAvailableInvestment());
        $this->assertEquals(3, $tranche->getInterestRate());
        $this->assertEquals('A', $tranche->getName());
    }
}
