<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\Command\{Command, CommandHandler as Contract};
use Throwable;

abstract class CommandHandler implements Contract
{
    /**
     * @param Command $command
     * @return mixed
     * @throws Throwable
     */
    abstract public function handle(Command $command): mixed;
}
