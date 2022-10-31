<?php

namespace App\Observers;

use App\Models\User;
use Psr\Log\LoggerInterface;

class UserObserver
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        $this->writeToLog('Добавлен новый пользователь', $user);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user): void
    {
        $this->writeToLog('Изменен пользователь', $user);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user): void
    {
        $this->writeToLog('Удален пользователь', $user);
    }

    /**
     * Handle the User "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user): void
    {
        $this->writeToLog('Восстановлен пользователь', $user);
    }

    private function writeToLog(string $message, User $user): void
    {
        $this->logger->info(
            sprintf('%s #%d', $message, $user->id),
            $user->getChanges()
        );
    }
}
