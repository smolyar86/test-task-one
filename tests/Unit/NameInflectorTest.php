<?php

namespace Tests\Unit;

use App\Commands\CommandHandler;
use App\Commands\NameInflector;
use App\Contracts\Command\Command;
use PHPUnit\Framework\TestCase;

class NameInflectorTest extends TestCase
{
    private NameInflector $inflector;

    public function setUp(): void
    {
        $this->inflector = new NameInflector();
    }

    /**
     * @test
     */
    public function should_return_handler_class_name()
    {
        $this->assertEquals(
            CreateUserHandler::class,
            $this->inflector->inflect(new CreateUser())
        );
    }
}

class CreateUser implements Command
{

}

class CreateUserHandler extends CommandHandler
{
    public function handle(Command $command): mixed
    {
        return null;
    }
}
