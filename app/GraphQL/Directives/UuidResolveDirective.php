<?php declare(strict_types=1);

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgTransformerDirective;
use Illuminate\Database\Eloquent\Model;
use GraphQL\Error\Error;

final class UuidResolveDirective extends BaseDirective implements ArgDirective, ArgTransformerDirective
{
    // TODO implement the directive https://lighthouse-php.com/master/custom-directives/getting-started.html

    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
directive @uuidResolve on INPUT_FIELD_DEFINITION
GRAPHQL;
    }

    /**
     * Apply transformations on the value of an argument given to a field.
     *
     * @param  mixed  $argumentValue  the client given value
     *
     * @return mixed the transformed value
     */
    public function transform(mixed $argumentValue): mixed
    {
        
        $modelClass = $this->directiveArgValue('model');

         if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
             throw new Error("The class {$modelClass} is not a valid model.");
         }
 
         $model = $modelClass::where('uuid', $argumentValue)->first();
 
         if (!$model) {
             throw new Error("No model found with UUID: {$argumentValue}");
         }

         return $model->id;
    }
}
