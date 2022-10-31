<?php

declare(strict_types=1);

namespace App\Validation;

use Illuminate\Validation\Rule;

class User
{
    public static function rules(int $userId): array
    {
        $unique = Rule::unique('users');

        if ($userId) {
            $unique->ignore($userId);
        }

        return [
            'name' => [
                'required',
                'regex:/(^([a-z0-9]+)?$)/u',
                'not_bad_word',
                $unique,
                'min:8',
                'max:64',
            ],
            'email' => [
                'required',
                'not_illegal_domain',
                $unique,
                'email:rfc',
                'max:256'
            ]
        ];
    }
}
