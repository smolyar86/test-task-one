<?php

declare(strict_types=1);

namespace App\Contracts\Command;

interface Inflector
{
    /**
     * @param Command $command
     * @return string
     */
    public function inflect(Command $command): string;
}
