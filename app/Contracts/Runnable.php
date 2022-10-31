<?php

declare(strict_types=1);

namespace App\Contracts;

interface Runnable
{
    /**
     * Run the function.
     *
     * @return mixed
     */
    public function handle(): mixed;
}
