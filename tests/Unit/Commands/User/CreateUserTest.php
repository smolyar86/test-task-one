<?php

namespace Tests\Unit\Commands\User;

use Illuminate\Validation\ValidationException;
use Mockery;
use App\Commands\CommandBus;
use App\Commands\NameInflector;
use App\Commands\User\CreateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $modelMock = Mockery::mock('App\Model\User');
        $modelMock->shouldReceive('saveOrFail')->andReturn($modelMock);
        $this->app->instance('App\Model\User', $modelMock);
    }

    /**
     * @test
     */
    public function executeCommand()
    {
        $user = $this->commandBus->execute(
            new CreateUser(
                'username',
                'mail@test.com',
                'notes'
            )
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('username', $user->name);
        $this->assertEquals('mail@test.com', $user->email);
        $this->assertEquals('notes', $user->notes);
        $this->assertNotEmpty($user->created);
    }

    /**
     * @test
     */
    public function failValidateUserWithNameLess8Chars()
    {
        try {
            $command = new CreateUser(
                'user',
                'mail@test.com'
            );
            $command->validate();

        } catch (ValidationException $e) {
            $this->assertSame('The name must be at least 8 characters.', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }

    /**
     * @test
     */
    public function failValidateUserWithNameMore64chars()
    {
        try {
            $command = new CreateUser(
                str_repeat('user', 20),
                'mail@test.com'
            );
            $command->validate();
        } catch (ValidationException $e) {
            $this->assertSame('The name must not be greater than 64 characters.', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }

    /**
     * @test
     */
    public function failValidateUserWithIllegalName()
    {
        try {
            $command = new CreateUser(
                'User Name',
                'mail@test.com'
            );
            $command->validate();
        } catch (ValidationException $e) {
            $this->assertSame('The name format is invalid.', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }

    /**
     * @test
     */
    public function failValidateUserWithBadName()
    {
        try {
            $command = new CreateUser(
                'motherfucker',
                'mail@test.com'
            );
            $command->validate();
        } catch (ValidationException $e) {
            $this->assertSame('validation.not_bad_word', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }

    /**
     * @test
     */
    public function failValidateUserWithIllegalEmail()
    {
        try {
            $command = new CreateUser(
                'username',
                'mail'
            );
            $command->validate();
        } catch (ValidationException $e) {
            $this->assertSame('The email must be a valid email address.', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }

    /**
     * @test
     */
    public function failValidateUserWithBadMailDomain()
    {
        try {
            $command = new CreateUser(
                'goodusername',
                'mail@fuck.com'
            );
            $command->validate();
        } catch (ValidationException $e) {
            $this->assertSame('validation.not_illegal_domain', $e->getMessage());
            return;
        }

        $this->fail('ValidationException was not thrown.');
    }
}
