<?php

namespace Tests\Feature\Commands\User;

use App\Commands\CommandBus;
use App\Commands\NameInflector;
use App\Commands\User\CreateUser;
use App\Commands\User\DeleteUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    private int $userId = 0;

    public function setUp(): void
    {
        parent::setUp();
        $this->commandBus = new CommandBus($this->app, new NameInflector());

        $user = $this->commandBus->execute(
            new CreateUser(
                'username',
                'mail@test.com'
            )
        );

        $this->userId = (int)$user->id;
    }

    /**
     * @test
     */
    public function delete_user()
    {
        $this->commandBus->execute(new DeleteUser($this->userId));
        $this->assertSoftDeleted('users', ['id' => $this->userId], deletedAtColumn: 'deleted');
    }
}
