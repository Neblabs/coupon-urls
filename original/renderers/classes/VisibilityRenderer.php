<?php

namespace CouponURLs\Original\Renderers\Classes;

use CouponURLs\Original\Renderers\RendererDecorator;

Class VisibilityRenderer extends RendererDecorator
{
    private $visibility = 'public';

    public function setVisibility(string $visibility)
    {
        $this->visibility = $visibility;   
    }
    
    public function render() : string
    {
        return "{$this->visibility} {$this->renderer->render()}";
    }
}
return; 
//  usage
(object) $methodRenderer = new VisibilityRenderer(
    new FunctionRenderer(
        New FunctionArgumentsRenderer([
            new TypedFunctionArgumentRenderer(
                new DefaultVariableValueRenderer(
                    new VariableRenderer
                )
            )
        ]), 
        new FunctionReturnTypeRenderer, 
        new FunctionBodyRenderer()
    )
);

$propertyRenderer = new InlineStatementRenderer(
    new VisibilityRenderer(
        new VariableRenderer
    )
);

$typedPropertyRenderer = new InlineStatementRenderer(
    new VisibilityRenderer(
        new TypedFunctionArgumentRenderer(
            new VariableRenderer
        )
    )
);

$importRenderer = new InlineStatementsRenderer([
    new ImportRenderer(Validator::class)
]);

//
// WE JUST NEED TO RENDER THE IMPORTS!
//
//

$methodRenderer->render();
