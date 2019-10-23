<?php

namespace App\Entity\Traits;

/**
 * Trait EntityPersonTrait.
 */
trait EntityPersonTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $prenom;

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     *
     * @return self
     */
    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     *
     * @return self
     */
    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return string
     */
    public function getNomPrenom(): string
    {
        return $this->getNom().' '.$this->getPrenom();
    }
}
