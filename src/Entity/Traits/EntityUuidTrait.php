<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Trait EntityUuidTrait.
 */
trait EntityUuidTrait
{
    /**
     * The internal primary identity key.
     *
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid", unique=true)
     */
    protected $uuid;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @ORM\PrePersist()
     *
     * @throws Exception
     */
    public function generateUuid()
    {
        $this->uuid = Uuid::uuid4();
    }
}
