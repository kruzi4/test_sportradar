<?php

namespace App\Classes;

use InvalidArgumentException;

readonly class Team
{
    public function __construct(
        protected string $name
    ) {
        empty($name)
        || (!preg_match("/[\w-]*/", $name)
            && throw new InvalidArgumentException('Team name cannot be empty or contain invalid characters'));
    }

    public function getName(): string
    {
        return $this->name;
    }
}