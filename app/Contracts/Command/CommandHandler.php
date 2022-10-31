<?php

declare(strict_types=1);

namespace App\Contracts\Command;

interface CommandHandler
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command);
}
