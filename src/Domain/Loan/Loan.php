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
     * Get Loan Tranches
     *
     * @return array|Tranche[]|null
     */
    public function getTranches(): ?array
    {
        return $this->tranches;
    }

    /**
     * Get Loan Tranche by Name
     *
     * @param string $name
     * @return Tranche
     * @throws InvalidArgumentException
     */
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
