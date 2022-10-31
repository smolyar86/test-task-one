<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\Command\{Command, Inflector};

class NameInflector implements Inflector
{
    /**
     * @param Command $command
     * @return string
     */
    public function inflect(Command $command): string
    {
        return $command::class . 'Handler';
    }
}
