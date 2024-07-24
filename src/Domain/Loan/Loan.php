<?php

declare(strict_types=1);

namespace LendInvest\Domain;

use DateTime;
use InvalidArgumentException;
use LendInvest\Domain\Tranche;

class Loan
{
    protected DateTime $startDate;
    protected DateTime $endDate;
    protected ?array $tranches;

    public function __construct(
        DateTime $startDate,
        DateTime $endDate,
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Get Start Date
     * 
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * Set Loan Start Date
     * 
     * @param DateTime $startDate
     * @return Loan
     */
    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get Loan End Date
     * 
     * @return Datetime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * Set Loan End Date
     * 
     * @param Datetime $endDate
     * @return Loan
     */
    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get Loan Tranches
     * 
     * @return array|Tranche[]|null
     */
    public function getTranches(): ?array
    {
        return $this->tranches;
    }

    public function getTrancheByName(string $name): Tranche
    {
        $tranches = $this->getTranches();

        if (isset($tranches[$name])) {
            return $tranches[$name];
        }

        throw new InvalidArgumentException(sprintf('No Tranche with the name $s has been found.', $name));
    }

    /**
     * Set Loan Tranches
     * 
     * @param Array|Tranche[]|null $tranches
     * @return Loan
     */
    public function setTranches($tranches): self
    {
        $this->tranches = $tranches;

        return $this;
    }
}
