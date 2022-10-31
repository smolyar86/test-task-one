<?php

declare(strict_types=1);

namespace App\Contracts\Command;

interface Validates
{
    /**
     * Run the function.
     *
     * @return void
     */
    public function validate(): void;
}
