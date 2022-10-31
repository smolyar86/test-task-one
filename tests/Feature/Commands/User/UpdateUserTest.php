<?php

namespace Tests\Feature\Commands\User;

use App\Commands\CommandBus;
use App\Commands\NameInflector;
use App\Commands\User\CreateUser;
use App\Commands\User\UpdateUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdateUserTest extends TestCase
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

        $this->commandBus->execute(
            new CreateUser(
                'uniqueusername',
                'uniquemail@test.com'
            )
        );
    }

    /**
     * @test
     */
    public function changeUser()
    {
        $command = new UpdateUser($this->userId);
        $command->setName('newusername');
        $command->setNotes('notes');

        $user = $this->commandBus->execute($command);

        $this->assertDatabaseHas('users', $user->toArray());
    }

    /**
     * @test
     */
    public function failChangeEmailToNotUnique()
    {
        $command = new UpdateUser($this->userId);
        $command->setEmail('uniquemail@test.com');

        try {
            $this->commandBus->execute($command);
        } catch (ValidationException $e) {
            $this->assertSame('The email has already been taken.', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }

    /**
     * @test
     */
    public function failChangeUsernameToNotUnique()
    {
        $command = new UpdateUser($this->userId);
        $command->setName('uniqueusername');

        try {
            $this->commandBus->execute($command);
        } catch (ValidationException $e) {
            $this->assertSame('The name has already been taken.', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }
}
