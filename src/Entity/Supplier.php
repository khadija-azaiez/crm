<?php


namespace App\Entity;


final class Supplier extends Person
{
    /** @var string */
    private $codeTva;

    /**
     * @return string
     */
    public function getCodeTva(): string
    {
        return $this->codeTva;
    }

    /**
     * @param string $codeTva
     */
    public function setCodeTva(string $codeTva): void
    {
        $this->codeTva = $codeTva;
    }
}
