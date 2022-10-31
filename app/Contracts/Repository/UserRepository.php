<?php

declare(strict_types=1);

namespace App\Contracts\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepository
{
    public function getUsers(int $page = 1, int $size = 20, string $pagerName = 'page'): LengthAwarePaginator;

    public function getUserById(int $userId): mixed;
}
