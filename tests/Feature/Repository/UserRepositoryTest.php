<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private UserRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository(new User());

        User::factory()->count(24)->create();
    }

    /**
     * @test
     */
    public function testGetUserById()
    {
        $user = User::factory()->create();
        $userFromRepository = $this->repository->getUserById($user->id);
        $this->assertEquals($user->id, $userFromRepository->id);
    }

    /**
     * @test
     */
    public function testNotFoundGetUserById()
    {
        $id = DB::table('users')->max('id');

        try {
            $this->repository->getUserById($id + 1);
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
            return;
        }

        $this->fail('ModelNotFoundException was not thrown.');
    }

    /**
     * @test
     */
    public function testGetUsersPageOne()
    {
        $users = $this->repository->getUsers(1);
        $this->assertEquals(20, $users->count());
    }

    /**
     * @test
     */
    public function testGetUsersPageTwo()
    {
        $users = $this->repository->getUsers(2);
        $this->assertGreaterThan(0, $users->count());
    }
}
