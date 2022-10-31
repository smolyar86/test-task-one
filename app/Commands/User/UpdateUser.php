<?php

declare(strict_types=1);

namespace App\Commands\User;

use App\Commands\Command;
use App\Validation;
use Illuminate\Support\Collection;

class UpdateUser extends Command
{
    protected int $id;
    protected ?string $name = null;
    protected ?string $email = null;
    protected ?string $notes = null;

    private Collection $changes;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->changes = collect();
    }

    /**
     * @return array[]
     */
    protected function rules(): array
    {
        $rules = Validation\User::rules($this->id);

        foreach ($rules as $field => $rule) {
            if (!$this->changed($field)) {
                unset($rules[$field]);
            }
        }

        return $rules;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        $this->markAsChanged('name');
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
        $this->markAsChanged('email');
    }

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
        $this->markAsChanged('notes');
    }

    /**
     * @param string $field
     * @return void
     */
    private function markAsChanged(string $field): void
    {
        if (!$this->changes->has($field)) {
            $this->changes->put($field, true);
        }
    }

    public function changed(string $field): bool
    {
        return $this->changes->has($field);
    }

    /**
     * @return array
     */
    public function getChanges(): array
    {
        $changes = [];

        foreach ($this->changes->keys() as $name) {
            $changes[$name] = $this->$name;
        }

        return $changes;
    }
}
