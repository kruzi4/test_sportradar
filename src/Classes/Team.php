<?php

namespace App\Classes;

use InvalidArgumentException;

readonly class Team
{
    protected string $name;

    public function __construct(
        string $name
    ) {
        (!preg_match("/[ \w-]*/", $name) || empty($name))
            && throw new InvalidArgumentException('Team name cannot be empty or contain invalid characters');

        $this->name = trim($name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}