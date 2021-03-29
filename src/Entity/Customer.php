<?php


namespace App\Entity;


final class Customer extends Person
{
    /** @var int */
    private $cin;

    /**
     * @return int
     */
    public function getCin(): int
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin(int $cin): void
    {
        $this->cin = $cin;
    }
}