<?php

namespace CouponURLS\Original\Deployment\Transformers\Abilities;

use CouponURLS\Original\Collections\Collection;
use CouponURLS\Original\Deployment\Transformers\ConditionalTransformer;
use ReflectionClass;

use function CouponURLS\Original\Utilities\Collection\_;

class TransformersFactory
{
    public function create(Collection $transformers) : Collection
    {
        // i shuld extract each of this into there own factory, but this will have to do for now...
        return $transformers->map(function(Transformable|string $transformer) : Transformable {
            if (is_string($transformer)) {
                $transformerToUse = new $transformer;
            } else {
                $transformerToUse = $transformer;
            }

            if ($transformer instanceof ValidatableTransformable) {
                $transformerToUse = new ConditionalTransformer(
                    transformer: $this->getTransformerAttributeValidatorsfunction(
                        $transformer, $transformerToUse
                    ),
                    transformerValidator: $transformer
                );
            }
            /*(object) $transformerToUse = match(true) {
                is_string($transformer) => new $transformer,
                $transformer instanceof ValidatableTransformable => new ConditionalTransformer(
                    transformer: $transformer,
                    transformerValidator: $transformer
                ),
                default => $transformer
            };

            $transformerToUse = $this->getTransformerAttributeValidatorsfunction($transformer, $transformerToUse);*/

            return $transformerToUse;
        });
    }

    protected function getTransformerAttributeValidatorsfunction(Transformable|IsDecorator $transformer, $transformerToUse) 
    {
        $reflectionClass = new ReflectionClass($transformer);

        (object) $attributes = _();

        while ($reflectionClass->implementsInterface(IsDecorator::class)) {
            $transformer = $transformer->decorated();
            $reflectionClass = new ReflectionClass($transformer);
            $attributes->concat($reflectionClass->getAttributes());
        };

        foreach ($reflectionClass->getAttributes() as $attribute) {
            if (is_a($attribute->getName(), ValidatableTransformable::class, allow_string: true)) {
                $transformerToUse = new ConditionalTransformer(
                    transformer: $transformerToUse,
                    transformerValidator: $attribute->newInstance()
                );
            }
        }

        return $transformerToUse;
    }
    
}