<?php

declare(strict_types=1);

namespace App\Commands\User;

use App\Commands\CommandHandler;
use App\Commands\User\DeleteUser as Command;
use App\Contracts\Command\Command as CommandContract;
use App\Models\User;

class DeleteUserHandler extends CommandHandler
{
    /**
     * @param Command|CommandContract $command
     * @return bool
     */
    public function handle(Command|CommandContract $command): bool
    {
        User::destroy([$command->getId()]);

        return true;
    }
}
