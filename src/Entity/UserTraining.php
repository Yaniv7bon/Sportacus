<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

//Represente les informations servant de base 
//à la realisation du programme d'un utilsateur 

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTrainingRepository")
 */
class UserTraining
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TrainingFrequency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TrainingLevel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TrainingType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="UserTraining", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainingFrequency(): ?string
    {
        return $this->TrainingFrequency;
    }

    public function setTrainingFrequency(string $TrainingFrequency): self
    {
        $this->TrainingFrequency = $TrainingFrequency;

        return $this;
    }

    public function getTrainingLevel(): ?string
    {
        return $this->TrainingLevel;
    }

    public function setTrainingLevel(string $TrainingLevel): self
    {
        $this->TrainingLevel = $TrainingLevel;

        return $this;
    }

    public function getTrainingType(): ?string
    {
        return $this->TrainingType;
    }

    public function setTrainingType(string $TrainingType): self
    {
        $this->TrainingType = $TrainingType;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
