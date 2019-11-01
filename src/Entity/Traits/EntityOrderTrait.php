<?php

namespace App\Entity\Traits;

use phpDocumentor\Reflection\Types\Integer;

/**
 * Trait EntityOrderTrait.
 */
trait EntityOrderTrait
{
    /**
     * @ORM\Column(type="integer")
     */
    private $ordre = 1;

    /**
     * @return int
     */
    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    /**
     * @param int $ordre
     *
     * @return $this
     */
    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
