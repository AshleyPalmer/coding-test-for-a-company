<?php

declare(strict_types=1);

namespace LendInvest\CodingTest\Domain\Loan;

use DateTime;
use InvalidArgumentException;
use LendInvest\CodingTest\Domain\Tranche\Tranche;

class Loan
{
    protected string $id;
    protected DateTime $startDate;
    protected DateTime $endDate;
    protected ?array $tranches = [];

    public function __construct(
        string $id,
        DateTime $startDate,
        DateTime $endDate,
    ) {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Get Loan ID
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set Loan ID
     *
     * @param  string $id
     * @return Loan
     */
    public function setId(string $id): self
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
     *
     * @param  DateTime $startDate
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
     * @param  Datetime $endDate
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
        /** @var Tranche $tranche */
        foreach ($this->getTranches() as $tranche) {
            if ($tranche->getName() === $name) {
                return $tranche;
            }
        }

        throw new InvalidArgumentException(sprintf('No Tranche with the name $s has been found.', $name));
    }

    /**
     * Set Loan Tranches
     *
     * @param  array|Tranche[]|null $tranches
     * @return Loan
     */
    public function setTranches(?array $tranches): self
    {
        $this->tranches = $tranches;

        return $this;
    }
}
