<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TreatmentRepository::class)
 */
class Treatment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="treatments")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=AppUser::class, inversedBy="treatments")
     */
    private $doctor;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="treatments")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity=Billing::class, mappedBy="treatment")
     */
    private $billings;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->billings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDoctor(): ?AppUser
    {
        return $this->doctor;
    }

    public function setDoctor(?AppUser $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->product->removeElement($product);

        return $this;
    }

    /**
     * @return Collection<int, Billing>
     */
    public function getBillings(): Collection
    {
        return $this->billings;
    }

    public function addBilling(Billing $billing): self
    {
        if (!$this->billings->contains($billing)) {
            $this->billings[] = $billing;
            $billing->setTreatment($this);
        }

        return $this;
    }

    public function removeBilling(Billing $billing): self
    {
        if ($this->billings->removeElement($billing)) {
            // set the owning side to null (unless already changed)
            if ($billing->getTreatment() === $this) {
                $billing->setTreatment(null);
            }
        }

        return $this;
    }
}
