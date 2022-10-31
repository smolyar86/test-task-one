<?php

declare(strict_types=1);

namespace App\Commands\User;

use App\Commands\Command;
use App\Validation;

class CreateUser extends Command
{
    protected string $name;
    protected string $email;
    protected ?string $notes;

    public function __construct(string $name, string $email, ?string $notes = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->notes = $notes;
    }

    /**
     * @return array[]
     */
    protected function rules(): array
    {
        return Validation\User::rules(0);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }
}
