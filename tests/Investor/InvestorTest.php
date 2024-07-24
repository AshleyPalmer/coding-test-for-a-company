<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Investor\Investor;

class InvestorTest extends TestCase
{

    #[Test]
    public function investorCanBeCreated(): void
    {
        $investorName = 'Test Investor';

        $investor = (new Investor($investorName))
            ->setWallet(new Wallet('1000'));

        $this->assertSame($investorName, $investor->getInvestorName());
    }
}
