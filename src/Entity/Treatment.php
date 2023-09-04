<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use DateTime;
use DateTimeZone;
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
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="treatment", cascade={"persist"})
     */
    private $invoice;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="treatments")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=AppUser::class, inversedBy="treatments")
     */
    private $doctor;

    /**
     * @ORM\OneToMany(targetEntity=Billing::class, mappedBy="treatment")
     */
    private $billings;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paid;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalCost;

    public function __construct()
    {
        $this->billings = new ArrayCollection();
        $this->invoice = new ArrayCollection();
    }

    public function __toString()
    {
        $date = $this->getDate(); //->format('F jS Y');
        $date ? '' : $date = new DateTime('now', new DateTimeZone('Pacific/Port_Moresby')); //->format('F jS Y');
        return $date->format('F jS Y') . ' ' . $this->getClient() . ' K' . $this->getTotalCost();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(?bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(?float $totalCost): self
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoice(): Collection
    {
        return $this->invoice;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoice->contains($invoice)) {
            $this->invoice[] = $invoice;
            $invoice->setTreatment($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoice->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getTreatment() === $this) {
                $invoice->setTreatment(null);
            }
        }

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }
}
