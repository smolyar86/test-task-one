<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\User\CreateUser;
use App\Commands\User\DeleteUser;
use App\Commands\User\UpdateUser;
use App\Contracts\Command\CommandBus;
use App\Contracts\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepository $repository;

    public function __construct(CommandBus $dispatcher, UserRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($dispatcher);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->repository->getUserById($id);
        return response()->json($user);
    }

    public function create(Request $request): JsonResponse
    {
        $command = new CreateUser(
            $request->input('name'),
            $request->input('email')
        );

        if ($request->has('notes')) {
            $command->setNotes($request->input('notes'));
        }

        $user = $this->dispatch($command);

        return response()->json($user);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $command = new UpdateUser($id);
        if ($request->has('name')) {
            $command->setName($request->input('name'));
        }

        if ($request->has('email')) {
            $command->setEmail($request->input('email'));
        }

        if ($request->has('notes')) {
            $command->setNotes($request->input('notes'));
        }

        $user = $this->dispatch($command);

        return response()->json($user);
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->repository->getUsers((int)$request->input('page'));
        return response()->json($users);
    }

    public function delete(int $id): JsonResponse
    {
        $result = $this->dispatch(new DeleteUser($id));
        return response()->json($result);
    }
}
