<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Wallet;

use Money\Money;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Wallet\Wallet;

class WalletTest extends TestCase
{

    #[Test]
    public function test_wallet_can_be_created(): void
    {
        $wallet = new Wallet('1000');
        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    #[Test]
    public function test_wallet_can_update_amount(): void
    {
        $initial = new Money('100', new Currency('GBP'));
        $updated = new Money('100000', new Currency('GBP'));

        $wallet = new Wallet('100');
        $this->assertEquals($initial, $wallet->getAmount());

        $wallet->setAmount($updated);
        $this->assertEquals($updated, $wallet->getAmount());
    }
}
