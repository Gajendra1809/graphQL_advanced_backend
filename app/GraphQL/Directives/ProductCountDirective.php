<?php declare(strict_types=1);

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;

final class ProductCountDirective extends BaseDirective implements FieldResolver
{
    // TODO implement the directive https://lighthouse-php.com/master/custom-directives/getting-started.html

    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
directive @productCount on FIELD_DEFINITION
GRAPHQL;
    }

    /**
     * Returns a field resolver function.
     *
     * @return callable(mixed, array<string, mixed>, \Nuwave\Lighthouse\Support\Contracts\GraphQLContext, \Nuwave\Lighthouse\Execution\ResolveInfo): mixed
     */
    public function resolveField(FieldValue $fieldValue): callable
    {

        return function ($rootValue, array $args, $context, $resolveInfo) use ($fieldValue) {
            if ($rootValue instanceof \App\Models\Category) {
                $count = $rootValue->products()->count();
                
                return $count;
            }

            return 0;
        };
    }
}
