<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements \App\Contracts\Repository\UserRepository
{
    private User $model;

    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $page
     * @param int $size
     * @param string $pagerName
     * @return LengthAwarePaginator
     */
    public function getUsers(int $page = 1, int $size = 20, string $pagerName = 'page'): LengthAwarePaginator
    {
        return $this->model->query()->paginate(
            $size,
            ['*'],
            $pagerName,
            $page
        );
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserById(int $userId): mixed
    {
        return $this->model->query()->findOrFail($userId);
    }
}
