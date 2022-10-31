<?php

declare(strict_types=1);

namespace App\Validation\Rules;

class NotInList
{
    protected array $list = [];

    public function __construct(array $list)
    {
        $this->list = $list;
    }

    public function validate(string $string): bool
    {
        if (empty($string)) {
            return true;
        }

        foreach ($this->list as $word) {
            if (stripos($string, $word) !== false) {
                return false;
            }
        }

        return true;
    }
}
