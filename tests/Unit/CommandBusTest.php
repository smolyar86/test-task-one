<?php

namespace Tests\Unit;

use App\Commands\CommandBus;
use App\Commands\NameInflector;
use Tests\TestCase;

class CommandBusTest extends TestCase
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->commandBus = new CommandBus( $this->app, new NameInflector());
    }

    /**
     * @test
     */
    public function should_call_method_handle_from_bus()
    {
        $this->assertEquals(
            $this->commandBus->execute(
                new CreateUser()
        ), null);
    }
}
