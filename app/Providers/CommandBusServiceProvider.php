<?php

declare(strict_types=1);

namespace App\Providers;

use App\Commands\CommandBus;
use App\Commands\NameInflector;
use App\Contracts\Command\CommandBus as CommandBusContract;
use App\Contracts\Command\Container;
use App\Contracts\Command\Inflector;
use App\LaravelContainer;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Inflector::class, NameInflector::class);
        $this->app->bind(CommandBusContract::class, CommandBus::class);
    }
}
