<?php

namespace CouponURLs\Original\Renderers\Factories;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Language\Classes\Property;
use CouponURLs\Original\Renderers\Abilities\Renderable;
use CouponURLs\Original\Renderers\Classes\VisibilityRenderer;
use CouponURLs\Original\Renderers\Functions\FunctionArgumentsRenderer;
use CouponURLs\Original\Renderers\Functions\FunctionRenderer;
use CouponURLs\Original\Renderers\Functions\FunctionReturnTypeRenderer;
use CouponURLs\Original\Renderers\Language\NativeTypedVariableRenderer;
use CouponURLs\Original\Renderers\Language\NewLineRenderer;
use CouponURLs\Original\Renderers\Language\TabRenderer;
use CouponURLs\Original\Renderers\Language\TextRenderer;
use CouponURLs\Original\Renderers\Language\VariableRenderer;

Class PropertyMethodsRendererFactory
{
    protected $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    public function getAll() : Collection
    {
        return new Collection([
            'getter' => $this->getGetterRenderer(),
            'setter' => $this->getSetterRenderer(),
        ]);   
    }

    public function getGetterRenderer() : Renderable
    {
        if (in_array($this->property->getVisibility(), ['public', 'readonly'])) {
            (string) $nameCapitalized = ucfirst($this->property->getName());
            (object) $functionRenderer = new FunctionRenderer;
            (object) $returnTypeRenderer = new FunctionReturnTypeRenderer;

            $functionRenderer->setName("{$this->property->getName()}");
            $functionRenderer->setReturnTypeRenderer($returnTypeRenderer);
            $functionRenderer->setBodyRenderer(new TextRenderer("return \$this->{$this->property->getName()};"));

            $returnTypeRenderer->setType($this->property->getShortType());

            return new NewLineRenderer(
                new NewLineRenderer(
                    new TabRenderer(
                        new VisibilityRenderer(
                            $functionRenderer
                        )
                    )
                )
            );  
        }

        return new TextRenderer('');
    }

    public function getSetterRenderer() : Renderable
    {
        if (in_array($this->property->getVisibility(), ['public'])) {
            (string) $nameCapitalized = ucfirst($this->property->getName());
            (object) $functionRenderer = new FunctionRenderer;
            (object) $returnTypeRenderer = new FunctionReturnTypeRenderer;
            (object) $argumentRenderer = new VariableRenderer($this->property->getName());
            (object) $typedArgumentRenderer = new NativeTypedVariableRenderer($argumentRenderer);

            $typedArgumentRenderer->setType($this->property->getShortType());

            (object) $argumentsRenderer = new FunctionArgumentsRenderer([
                $this->property->isTyped()? $typedArgumentRenderer : $argumentRenderer
            ]);

            $functionRenderer->setName("set{$nameCapitalized}");
            $functionRenderer->setArgumentsRenderer($argumentsRenderer);
            $functionRenderer->setBodyRenderer(new TextRenderer("\$this->{$this->property->getName()} = \${$this->property->getName()};"));

            $returnTypeRenderer->setType($this->property->getShortType());

            return new NewLineRenderer(
                new NewLineRenderer(
                    new TabRenderer(
                        new VisibilityRenderer(
                            $functionRenderer
                        )
                    )
                )
            );  
        }

        return new TextRenderer('');
    }
    
}