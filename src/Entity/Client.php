<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jobtitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $employer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insuranceprovider;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="client")
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity=Treatment::class, mappedBy="client")
     */
    private $treatments;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
        $this->treatments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getJobtitle(): ?string
    {
        return $this->jobtitle;
    }

    public function setJobtitle(?string $jobtitle): self
    {
        $this->jobtitle = $jobtitle;

        return $this;
    }

    public function getEmployer(): ?string
    {
        return $this->employer;
    }

    public function setEmployer(?string $employer): self
    {
        $this->employer = $employer;

        return $this;
    }

    public function getInsuranceprovider(): ?string
    {
        return $this->insuranceprovider;
    }

    public function setInsuranceprovider(?string $insuranceprovider): self
    {
        $this->insuranceprovider = $insuranceprovider;

        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setClient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getClient() === $this) {
                $appointment->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Treatment>
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(Treatment $treatment): self
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments[] = $treatment;
            $treatment->setClient($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->removeElement($treatment)) {
            // set the owning side to null (unless already changed)
            if ($treatment->getClient() === $this) {
                $treatment->setClient(null);
            }
        }

        return $this;
    }
}
