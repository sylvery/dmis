<?php

namespace App\Entity;

use App\Repository\StockItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockItemRepository::class)
 */
class StockItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="date")
     */
    private $dateIn;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOut;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sellingPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $revenue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $creditedAmount;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $debitedAmount;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $soldOut;

    /**
     * @ORM\OneToMany(targetEntity=DailySale::class, mappedBy="stockItem", cascade={"all"})
     */
    private $dailySales;

    public function __construct()
    {
        $this->dailySales = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName() . ' x' . $this->getQuantity();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDateIn(): ?\DateTimeInterface
    {
        return $this->dateIn;
    }

    public function setDateIn(\DateTimeInterface $dateIn): self
    {
        $this->dateIn = $dateIn;

        return $this;
    }

    public function getDateOut(): ?\DateTimeInterface
    {
        return $this->dateOut;
    }

    public function setDateOut(?\DateTimeInterface $dateOut): self
    {
        $this->dateOut = $dateOut;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getRevenue(): ?float
    {
        return $this->revenue;
    }

    public function setRevenue(?float $revenue): self
    {
        $this->revenue = $revenue;

        return $this;
    }

    public function getSoldOut(): ?bool
    {
        return $this->soldOut;
    }

    public function setSoldOut(?bool $soldOut): self
    {
        $this->soldOut = $soldOut;

        return $this;
    }

    /**
     * @return Collection|DailySale[]
     */
    public function getDailySales(): Collection
    {
        return $this->dailySales;
    }

    public function addDailySale(DailySale $dailySale): self
    {
        if (!$this->dailySales->contains($dailySale)) {
            $this->dailySales[] = $dailySale;
            $dailySale->setStockItem($this);
        }

        return $this;
    }

    public function removeDailySale(DailySale $dailySale): self
    {
        if ($this->dailySales->removeElement($dailySale)) {
            // set the owning side to null (unless already changed)
            if ($dailySale->getStockItem() === $this) {
                $dailySale->setStockItem(null);
            }
        }

        return $this;
    }

    public function getSellingPrice(): ?float
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(float $sellingPrice): self
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    public function getCreditedAmount(): ?float
    {
        return $this->creditedAmount;
    }

    public function setCreditedAmount(?float $creditedAmount): self
    {
        $this->creditedAmount = $creditedAmount;

        return $this;
    }

    public function getDebitedAmount(): ?float
    {
        return $this->debitedAmount;
    }

    public function setDebitedAmount(?float $debitedAmount): self
    {
        $this->debitedAmount = $debitedAmount;

        return $this;
    }
}
