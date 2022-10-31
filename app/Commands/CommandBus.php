<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\Command\{Command, CommandBus as Contract, CommandHandler, Inflector, Validates};
use Illuminate\Contracts\Container\Container;

class CommandBus implements Contract
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * @var Inflector
     */
    private Inflector $inflector;

    /**
     * Create a new CommandBus
     *
     * @param Container $container
     * @param Inflector $inflector
     */
    public function __construct(Container $container, Inflector $inflector)
    {
        $this->container = $container;
        $this->inflector = $inflector;
    }

    /**
     * @param Command $command
     * @return mixed
     */
    public function execute(Command $command): mixed
    {
        if ($command instanceof Validates) {
            $command->validate();
        }

        return $this->handler($command)->handle($command);
    }

    /**
     * Get the Command Handler
     *
     * @param Command $command
     * @return CommandHandler
     */
    private function handler(Command $command): CommandHandler
    {
        $class = $this->inflector->inflect($command);

        return $this->container->make($class);
    }
}
