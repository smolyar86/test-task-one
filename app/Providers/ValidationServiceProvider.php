<?php

declare(strict_types=1);

namespace App\Providers;

use App\Validation\Rules\NotBadWord;
use App\Validation\Rules\NotIllegalDomain;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(NotBadWord::class, function () {
            return new NotBadWord(config('validation.bad_words'));
        });

        $this->app->singleton(NotIllegalDomain::class, function () {
            return new NotBadWord(config('validation.illegal_domains'));
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        app('validator')->extend('not_bad_word', function ($attribute, $value, $parameters, $validator) {
            return app(NotBadWord::class)->validate($value);
        });

        app('validator')->extend('not_illegal_domain', function ($attribute, $value, $parameters, $validator) {
            return app(NotIllegalDomain::class)->validate($value);
        });
    }
}
