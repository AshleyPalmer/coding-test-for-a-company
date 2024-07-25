<?php

use Money\Money;
use Money\Currency;
use LendInvest\CodingTest\Domain\Loan\Loan;
use LendInvest\CodingTest\Domain\Wallet\Wallet;
use LendInvest\CodingTest\Domain\Tranche\Tranche;
use LendInvest\CodingTest\Domain\Loan\LoanService;
use LendInvest\CodingTest\Domain\Investor\Investor;
use LendInvest\CodingTest\Domain\LoanPool\LoanPool;
use LendInvest\CodingTest\Domain\Investor\InvestorService;
use LendInvest\CodingTest\Domain\Investment\InvestmentService;

require dirname(__DIR__) . '/vendor/autoload.php';

function main()
{
    echo "Creating Investor 1\n";
    $investor1 = (new Investor('Investor 1'))
        ->setWallet(new Wallet('100000'));

    echo "Creating Investor 2\n";
    $investor2 = (new Investor('Investor 2'))
        ->setWallet(new Wallet('100000'));

    echo "Creating Investor 3\n";
    $investor3 = (new Investor('Investor 3'))
        ->setWallet(new Wallet('100000'));

    echo "Creating Investor 4\n";
    $investor4 = (new Investor('Investor 4'))
        ->setWallet(new Wallet('100000'));

    echo "Creating Loan\n";
    $loan = new Loan(
        'Loan',
        DateTime::createFromFormat('d/m/Y', '01/10/2023'),
        DateTime::createFromFormat('d/m/Y', '15/11/2023')
    );

    echo "Creating Tranches for Loan\n";
    $loanService = new LoanService($loan);
    $loan = $loanService->createTranche(Tranche::TRANCHE_A, 3, new Money('100000', new Currency('GBP')));
    $loan = $loanService->createTranche(Tranche::TRANCHE_B, 6, new Money('100000', new Currency('GBP')));

    echo "Creating Loan pool with loan\n";
    $loanPool = new LoanPool([$loan]);

    echo "Attempting to create a £1000 Investment in tranche A, with the investment date 03/10/2023 for Investor 1\n";
    $investorService = new InvestorService($investor1);
    $investor1 = $investorService->createInvestment(
        '1',
        new Money('100000', new Currency('GBP')),
        DateTime::createFromFormat('d/m/Y', '03/10/2023'),
        Tranche::TRANCHE_A,
        'Loan',
        $loanPool
    );

    echo "Attempting to create a £1 Investment in tranche A, with the investment date 04/10/2023 for Investor 2\n";
    $investorService = new InvestorService($investor2);
    try {
        $investor2 = $investorService->createInvestment(
            '2',
            new Money('100', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '04/10/2023'),
            Tranche::TRANCHE_A,
            'Loan',
            $loanPool
        );
    } catch (Throwable $e) {
        echo sprintf("Failed to create investment: %s\n", $e->getMessage());
    }

    echo "Attempting to create a £500 Investment in tranche B, with the investment date 10/10/2023 for Investor 3\n";
    $investorService = new InvestorService($investor3);
    $investor3 = $investorService->createInvestment(
        '3',
        new Money('50000', new Currency('GBP')),
        DateTime::createFromFormat('d/m/Y', '10/10/2023'),
        Tranche::TRANCHE_B,
        'Loan',
        $loanPool
    );

    echo "Attempting to create a £1,100 Investment in tranche B, with the investment date 25/10/2023 for Investor 4\n";
    $investorService = new InvestorService($investor4);
    try {
        $investor4 = $investorService->createInvestment(
            '4',
            new Money('110000', new Currency('GBP')),
            DateTime::createFromFormat('d/m/Y', '25/10/2023'),
            Tranche::TRANCHE_B,
            'Loan',
            $loanPool
        );
    } catch (Throwable $e) {
        echo sprintf("Failed to create investment: %s\n", $e->getMessage());
    }

    echo "\n\n";
    echo "---- Calculating interest earned for period ----\n\n";

    $investmentService = new InvestmentService($investor1->getInvestmentById('1'));
    $result1 = $investmentService->getEarnedAmountForPeriod(DateTime::createFromFormat('d/m/Y', '31/10/2023'));
    echo sprintf("%s earned £%s", $investor1->getInvestorName(), ($result1->getAmount() / 100));
    echo "\n";

    $investmentService = new InvestmentService($investor3->getInvestmentById('3'));
    $result3 = $investmentService->getEarnedAmountForPeriod(DateTime::createFromFormat('d/m/Y', '31/10/2023'));
    echo sprintf("%s earned £%s", $investor3->getInvestorName(), ($result3->getAmount() / 100));
    echo "\n\n\n";
}

function outro()
{
    echo "\n";
    echo "Thanks for reviewing my code!\n" .
        "This has been a pretty fun challenge,\n" .
        "albeit it has taken some time to complete..\n" .
        "But I hope it's good enough :)\n" .
        "- Ashley Palmer";
}

call_user_func('main');
call_user_func('outro');
