<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
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
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Espece::class, mappedBy="type")
     */
    private $especes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montagne;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prairie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $foret;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $plage;

    public function __construct()
    {
        $this->especes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Espece[]
     */
    public function getEspeces(): Collection
    {
        return $this->especes;
    }

    public function addEspece(Espece $espece): self
    {
        if (!$this->especes->contains($espece)) {
            $this->especes[] = $espece;
            $espece->addType($this);
        }

        return $this;
    }

    public function removeEspece(Espece $espece): self
    {
        if ($this->especes->contains($espece)) {
            $this->especes->removeElement($espece);
            $espece->removeType($this);
        }

        return $this;
    }

    public function getMontagne(): ?int
    {
        return $this->montagne;
    }

    public function setMontagne(?int $montagne): self
    {
        $this->montagne = $montagne;

        return $this;
    }

    public function getPrairie(): ?int
    {
        return $this->prairie;
    }

    public function setPrairie(?int $prairie): self
    {
        $this->prairie = $prairie;

        return $this;
    }

    public function getVille(): ?int
    {
        return $this->ville;
    }

    public function setVille(?int $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getForet(): ?int
    {
        return $this->foret;
    }

    public function setForet(?int $foret): self
    {
        $this->foret = $foret;

        return $this;
    }

    public function getPlage(): ?int
    {
        return $this->plage;
    }

    public function setPlage(?int $plage): self
    {
        $this->plage = $plage;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
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
}
