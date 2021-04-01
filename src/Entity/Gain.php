<?php


namespace App\Entity;


class Gain
{
    /** @var int */
    private $id;

    /** @var \DateTime */
    private $date;

    /** @var float */
    private $montant;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getMontant(): float
    {
        return $this->montant;
    }

    /**
     * @param float $montant
     */
    public function setMontant(float $montant): void
    {
        $this->montant = $montant;
    }
}