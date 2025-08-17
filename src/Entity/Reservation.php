<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

     #[ORM\Column(length: 255)]
    private ?string $race_dog = null;

     #[ORM\Column(length: 255)]
     private ?string $nameOfDog = null;

     #[ORM\ManyToOne(inversedBy: 'reservations')]
     private ?User $user = null;

     #[ORM\ManyToOne(inversedBy: 'reservations')]
     #[ORM\JoinColumn(nullable: false)]
     private ?Service $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

  
    public function getRaceDog(): ?string
    {
        return $this->race_dog;
    }

    public function setRaceDog(string $race_dog): static
    {
        $this->race_dog = $race_dog;

        return $this;
    }

    public function getNameOfDog(): ?string
    {
        return $this->nameOfDog;
    }

    public function setNameOfDog(string $nameOfDog): static
    {
        $this->nameOfDog = $nameOfDog;

        return $this;
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
}
