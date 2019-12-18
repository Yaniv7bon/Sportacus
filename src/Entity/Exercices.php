<?php

namespace App\Entity;

use App\Form\UserTrainingType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExercicesRepository")
 */
class Exercices
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $groupeMusculaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Level;

    public function getArray()
    {
        return get_object_vars($this);
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

    public function getGroupeMusculaire(): ?string
    {
        return $this->groupeMusculaire;
    }

    public function setGroupeMusculaire(string $groupeMusculaire): self
    {
        $this->groupeMusculaire = $groupeMusculaire;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->Level;
    }

    public function setLevel(string $Level): self
    {
        $this->Level = $Level;

        return $this;
    }
}
