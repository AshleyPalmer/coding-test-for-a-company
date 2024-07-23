# LendInvest Coding Test

## Task details

- Each of our loans has a start date and an end date.
- Each loan is split into multiple tranches.
- Each tranche has a different monthly interest percentage.
- Each tranche has a maximum amount available to invest. So once the maximum is
  reached, further investments can't be made in that tranche.
- As an investor, I can invest in a tranche at any time if the loan is still open, the maximum
  available amount was not reached and I have enough money in my virtual wallet.
- At the end of the month we need to calculate the interest each investor is due to be paid.

## Scenarios

> - Given a loan (start 01/10/2023 end 15/11/2023).
> - Given the loan has 2 tranches called A and B (3% and 6% monthly interest rate) each with
>   1,000 pounds amount available.
> - Given each investor has 1,000 pounds in his virtual wallet.
> - “Investor 1” would like to invest 1,000 pounds in the tranche “A” on 03/10/2023: this is allowed and the software should go on without errors.
> - “Investor 2” would like to invest 1 pound in the tranche “A” on 04/10/2023: the maximum amount for the tranche A is 1000, the investor 2 should not be allowed to invest
> - “Investor 3” would like to invest 500 pounds on the tranche “B” on 10/10/2023: this is allowed and the software should go on without errors
> - “Investor 4” would like to invest 1,100 pounds in the tranche “B” 25/10/2023: the investor 4 does not have enough money to invest the requested amount, and the tranche is smaller than the amount requested.
> - On 01/11/2023 the system runs the interest calculation for the period 01/10/2023 ->
>   31/10/2023:
> - “Investor 1” earns 28.06 pounds
> - “Investor 3” earns 21.29 pounds

## Some Hints for the coding challenge:

The investor earnings are calculated as follows:

- Daily interest rate = Interest rate / Days in a month
- Invested period interest rate = Daily interest rate \* Days invested
- Earned interest = Invested amount / 100 \* Invested period interest rate (1)

(1) for instance, for investor1 it’s from the 3/10/2023 (included) to the end of month, so 31/10/2023

## Approach

### Objects

We will need to create four primary objects for this:

1. Investor - User investing into a loan
2. Loan - A Loan term with multiple tranches
3. Tranche - The investment pot with a maximum amount and set interest rate
4. Wallet - The Investors available capital

- Possibly also need a Money object

