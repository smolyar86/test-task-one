<?php

declare(strict_types=1);

namespace App\Contracts\Command;

interface CommandBus
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function execute(Command $command): mixed;
}
