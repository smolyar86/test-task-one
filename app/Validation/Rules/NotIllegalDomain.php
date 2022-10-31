<?php

declare(strict_types=1);

namespace App\Validation\Rules;

class NotIllegalDomain extends NotInList
{
    public function validate(string $string): bool
    {
        if (empty($string) || mb_strpos($string, '@') === false) {
            return false;
        }

        list(, $domain) = explode('@', $string);

        if (!$domain) {
            return false;
        }

        return parent::validate($domain);
    }
}
