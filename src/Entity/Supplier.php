<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 */
class Supplier
{
    use Person;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeTva;

    /**
     * @ORM\OneToMany(targetEntity=Spend::class, mappedBy="supplier")
     */
    private $spends;
    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="supplier")
     */
    private $products;

    public function __construct()
    {
        $this->spends = new ArrayCollection();
        $this->products = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeTva(): ?string
    {
        return $this->codeTva;
    }

    public function setCodeTva(string $codeTva): self
    {
        $this->codeTva = $codeTva;

        return $this;
    }

    /**
     * @return Collection|Spend[]
     */
    public function getSpends(): Collection
    {
        return $this->spends;
    }

    public function addSpend(Spend $spend): self
    {
        if (!$this->spends->contains($spend)) {
            $this->spends[] = $spend;
            $spend->setSupplier($this);
        }

        return $this;
    }

    public function removeSpend(Spend $spend): self
    {
        if ($this->spends->removeElement($spend)) {
            // set the owning side to null (unless already changed)
            if ($spend->getSupplier() === $this) {
                $spend->setSupplier(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

        return $this;
    }
}
