<?php

declare(strict_types=1);

namespace App\Commands\User;

use App\Commands\CommandHandler;
use App\Commands\User\CreateUser as Command;
use App\Contracts\Command\Command as CommandContract;
use App\Models\User;
use Throwable;

class CreateUserHandler extends CommandHandler
{
    /**
     * @param CreateUser|CommandContract $command
     * @return mixed
     * @throws Throwable
     */
    public function handle(Command|CommandContract $command): User
    {
        $user = new User([
            'name' => $command->getName(),
            'email' => $command->getEmail(),
        ]);

        if ($notes = $command->getNotes()) {
            $user->notes = $notes;
        }

        $user->saveOrFail();

        return $user;
    }
}
