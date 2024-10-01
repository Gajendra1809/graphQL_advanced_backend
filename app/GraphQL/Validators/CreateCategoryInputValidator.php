<?php declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateCategoryInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'category_name' => ['required', 'string', 'unique:categories,category_name'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_name.unique' => 'The category name has already been taken.',
        ];
    }
}
