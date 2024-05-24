<?php

namespace CouponURLs\App\Creation\Uri;

use CouponURLs\Original\Creation\Entities\Abilities\OverloadableEntitiesFactory;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Domain\URIs\HomePageURI;
use CouponURLs\App\Domain\URIs\PathURI;
use CouponURLs\Original\Creation\Abilities\CanCreateEntity;
use CouponURLs\Original\Creation\Abilities\CanCreateEntityWithParameters;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entity;
use Symfony\Component\HttpFoundation\Request;
use function CouponURLs\Original\Utilities\Text\i;

class PathURIFactory implements CanCreateEntity, OverloadableEntitiesFactory
{
    public function __construct(
        protected QueryParametersFromStringFactory $queryParametersFactory
    ) {}
    
    public function canCreateEntity(mixed $data): bool
    {
        return true;
    } 

    public function createEntity(mixed $data): Entity
    {
        return new PathURI(
            value: i($data->get('path') ?? '')->trimRight('/'),
            queryParameters: $this->queryParametersFactory->create(
                $data->get('query') ?? ''
            )
        );
    } 

    public function canCreateEntities(mixed $data): bool
    {
        return false;        
    } 
}