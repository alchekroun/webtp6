<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 */
class Pokemon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $courbeXP;

    /**
     * @ORM\Column(type="boolean")
     */
    private $evolution;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=PokemonType::class, inversedBy="pokemon")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity=PokemonType::class)
     */
    private $type2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCourbeXP(): ?string
    {
        return $this->courbeXP;
    }

    public function setCourbeXP(string $courbeXP): self
    {
        $this->courbeXP = $courbeXP;

        return $this;
    }

    public function getEvolution(): ?bool
    {
        return $this->evolution;
    }

    public function setEvolution(bool $evolution): self
    {
        $this->evolution = $evolution;

        return $this;
    }

    public function getType1(): ?PokemonType
    {
        return $this->type1;
    }

    public function setType1(?PokemonType $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?PokemonType
    {
        return $this->type2;
    }

    public function setType2(?PokemonType $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }
    
}
