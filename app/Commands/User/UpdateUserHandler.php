<?php

declare(strict_types=1);

namespace App\Commands\User;

use App\Commands\CommandHandler;
use App\Commands\User\UpdateUser as Command;
use App\Contracts\Command\Command as CommandContract;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserHandler extends CommandHandler
{
    /**
     * @param Command|CommandContract $command
     * @return mixed
     */
    public function handle(Command|CommandContract $command): mixed
    {
        return DB::transaction(function () use ($command) {
            $user = User::lockForUpdate()->findOrFail($command->getId());

            foreach ($command->getChanges() as $field => $value) {
                $user->$field = $value;
            }

            $user->saveOrFail();

            return $user;
        });
    }
}
