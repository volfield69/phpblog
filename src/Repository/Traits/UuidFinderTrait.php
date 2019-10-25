<?php

namespace App\Repository\Traits;

trait UuidFinderTrait
{
    public function findOneByUuid(string $uuid)
    {
        return $this->findOneBy([
            'uuid' => $uuid,
        ]);
    }
}
