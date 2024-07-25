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
    public static function getEarnedInterestAmount(Money $investment, int|float $interestRate): Money
    {
        $amount = $investment->getAmount();
        $earnedAmount = number_format(
            ($amount / 100) * $interestRate,
            0,
            '.',
            ''
        );

        return new Money($earnedAmount, new Currency('GBP'));
    }
}
