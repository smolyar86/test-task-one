<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Command\Command;
use App\Contracts\Command\CommandBus;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ValidatesRequests;

    private CommandBus $dispatcher;

    public function __construct(CommandBus $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(Command $command)
    {
        return $this->dispatcher->execute($command);
    }
}
