<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Calculator;

use Money\Money;
use Money\Currency;

class EarnedInterestCalculator
{
    /**
     * Calculates the amount earned from investment, 
     * and investment period interest rate
     * 
     * @param  Money     $investment
     * @param  int|float $interestRate
     * @return Money
     */
    public function getEarnedInterestAmount(Money $investment, int|float $interestRate): Money
    {
        $amount = $investment->getAmount();
        $earnedAmount = (($amount / 100) * $interestRate);

        return new Money(number_format($earnedAmount, 2, '.', ''), new Currency('GBP'));
    }
}
