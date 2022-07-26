<?php

declare(strict_types=1);

namespace App\Orchid\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Валідовані поля з даними за замовчуванням.
     *
     * @param array $defaultValues
     * @return array
     */
    public function validatedWithDefault(array $defaultValues = []): array
    {
        return $this->withDefault($this->validated(), $defaultValues);
    }

    /**
     * Обмежений набір полів з даними за замовчування
     *
     * @param array $onlyFields
     * @param array $defaultValues
     * @return array
     */
    public function onlyWithDefault(array $onlyFields, array $defaultValues = []): array
    {
        return $this->withDefault($this->only($onlyFields), $defaultValues);
    }

    /**
     * Поля з виключеним набором ключів з даними за замовчуванням
     *
     * @param array $exceptFields
     * @param array $defaultValues
     * @return array
     */
    public function exceptWithDefault(array $exceptFields, array $defaultValues = []): array
    {
        return $this->withDefault($this->except($exceptFields), $defaultValues);
    }

    /**
     * Всі поля з даними за замовчуванням
     *
     * @param array $defaultValues
     * @return array
     */
    public function allWithDefault(array $defaultValues = []): array
    {
        return $this->withDefault($this->all(), $defaultValues);
    }

    /**
     * Поле з даними за замовчуванням (якщо поле являється масивом)
     *
     * @param string $key
     * @param array $defaultValues
     * @return mixed
     */
    public function inputWithDefault(string $key, array $defaultValues = []): mixed
    {
        $value = $this->input($key);

        if (!is_array($value)) {
            return $value;
        }

        return $this->withDefault($value, $defaultValues);
    }

    public function withDefault(array $data, array $defaultValues): array
    {
        foreach ($defaultValues as $key => $defaultValue) {
            if (!isset($data[$key]) || is_null($data[$key])) {
                $data[$key] = $defaultValue;
            }
        }

        return $data;
    }
}