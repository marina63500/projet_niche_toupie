<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   

     #[ORM\ManyToOne(inversedBy: 'reservations')]
     private ?User $user = null;

     #[ORM\ManyToOne(inversedBy: 'reservations')]
     #[ORM\JoinColumn(nullable: false)]
     private ?Service $service = null;

     #[ORM\Column]
     private ?\DateTime $createdAt = null;

     #[ORM\Column]
     private ?int $price = null;

     #[ORM\Column]
     private ?\DateTime $reservationDate = null;

     #[ORM\Column]
     private ?int $status = null;

     #[ORM\Column]
     private array $historical = [];

     /**
      * @var Collection<int, Dog>
      */
     #[ORM\ManyToMany(targetEntity: Dog::class, mappedBy: 'reservations')]
     private Collection $dogs;

     public function __construct()
     {
         $this->dogs = new ArrayCollection();
     }

    public function getId(): ?int
    {
        return $this->id;
    }
   
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getReservationDate(): ?\DateTime
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTime $reservationDate): static
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getHistorical(): array
    {
        return $this->historical;
    }

    public function setHistorical(array $historical): static
    {
        $this->historical = $historical;

        return $this;
    }

    /**
     * @return Collection<int, Dog>
     */
    public function getDogs(): Collection
    {
        return $this->dogs;
    }

    public function addDog(Dog $dog): static
    {
        if (!$this->dogs->contains($dog)) {
            $this->dogs->add($dog);
            $dog->addReservation($this);
        }

        return $this;
    }

    public function removeDog(Dog $dog): static
    {
        if ($this->dogs->removeElement($dog)) {
            $dog->removeReservation($this);
        }

        return $this;
    }
}
