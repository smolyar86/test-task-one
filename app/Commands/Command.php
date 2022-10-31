<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\{Command\Command as Contract, Command\Validates};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class Command implements Contract, Validates
{
    /**
     * @return void
     * @throws ValidationException
     */
    public function validate(): void
    {
        $rules = $this->rules();

        if (empty($rules)) {
            return;
        }

        $validator = Validator::make(
            $this->validationData(array_keys($rules)),
            $rules,
            $this->messages(),
            $this->attributes()
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [];
    }

    /**
     * @param array $fields
     * @return array
     */
    protected function validationData(array $fields): array
    {
        $data = [];

        foreach ($fields as $field) {
            if (property_exists($this, $field)) {
                $data[$field] = $this->$field;
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    protected function messages(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function attributes(): array
    {
        return [];
    }
}
