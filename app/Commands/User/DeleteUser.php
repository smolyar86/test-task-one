<?php

declare(strict_types=1);

namespace App\Commands\User;

use App\Commands\Command;

class DeleteUser extends Command
{
    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
