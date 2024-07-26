<?php

declare(strict_types=1);

namespace Test\LendInvest\CodingTest\Domain\Wallet;

use Money\Money;
use Money\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Wallet\WalletService;

class WalletServiceTest extends TestCase
{

    protected Wallet $wallet;

    public function setUp(): void
    {
        $this->wallet = new Wallet('100000');
    }

    #[Test]
    public function test_check_has_balance_to_invest_successfully(): void
    {
        $requestAmount = new Money('50000', new Currency('GBP'));
        $walletService = new WalletService($this->wallet);
        $this->assertTrue($walletService->hasBalanceToInvest($requestAmount));
    }

    #[Test]
    public function test_check_insufficient_funds_to_invest(): void
    {
        $requestAmount = new Money('110000', new Currency('GBP'));
        $walletService = new WalletService($this->wallet);
        $this->expectException(InvalidArgumentException::class);
        $walletService->hasBalanceToInvest($requestAmount);
    }

    #[Test]
    public function test_deduct_from_wallet(): void
    {
        $requestAmount = new Money('50000', new Currency('GBP'));
        $walletService = new WalletService($this->wallet);
        $this->wallet = $walletService->deductFromWallet($requestAmount);
        $this->assertEquals($requestAmount, $this->wallet->getAmount());
    }
}
