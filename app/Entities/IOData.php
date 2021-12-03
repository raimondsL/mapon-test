<?php

namespace App\Entities;


class IOData implements \JsonSerializable
{

    public function __construct(
        private array $array
    )
    {
        //
    }

    public function jsonSerialize()
    {
        return $this->array;
    }
}
