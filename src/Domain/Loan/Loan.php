<?php

namespace LendInvest\Domain;

use DateTime;
use LendInvest\Domain\Tranche;

class Loan
{
    protected int $id;
    protected DateTime $startDate;
    protected DateTime $endDate;
    protected ?array $tranches;

    public function __construct(
        int $id,
        DateTime $startDate,
        DateTime $endDate,
        array $tranches = []
    ) {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tranches = $tranches;
    }

    /**
     * Get Loan ID
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * Set ID
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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
     * @param DateTime $startDate
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
     * @param Datetime $endDate
     */
    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get Loan Tranches
     * @return array|Tranche[]|null
     */
    public function getTranches(): ?array
    {
        return $this->tranches;
    }

    /**
     * Set Loan Tranches
     * @param Array|Tranche[]|null $tranches
     */
    public function setTranches($tranches): self
    {
        $this->tranches = $tranches;

        return $this;
    }
}
