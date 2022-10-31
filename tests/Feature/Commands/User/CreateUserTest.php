<?php

namespace Tests\Feature\Commands\User;

use App\Commands\CommandBus;
use App\Commands\NameInflector;
use App\Commands\User\CreateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->commandBus = new CommandBus($this->app, new NameInflector());
    }

    /**
     * @test
     */
    public function success_type_create_user()
    {
        $user = $this->commandBus->execute(
            new CreateUser(
                'username',
                'mail@test.com'
            )
        );

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function success_create_user()
    {
        $user = $this->commandBus->execute(
            new CreateUser(
                'username',
                'mail@test.com'
            )
        );

        $this->assertDatabaseHas('users', $user->toArray());
    }
}
