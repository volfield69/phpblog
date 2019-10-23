<?php

namespace App\Entity\Traits;

trait EntityIdTrait
{
    /**
     * The unique auto incremented primary key.
     *
     * @var null|int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
