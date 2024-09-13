<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Creation\Uri\HomePageURIFactory;
use CouponURLs\App\Creation\Uri\PathURIFactory;
use CouponURLs\Original\Creation\Entities\OverloadedEntitiesFactory;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use CouponURLs\Original\Domain\Entity;
use Symfony\Component\HttpFoundation\Request;

use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;

class URIDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    static public function type(): string
    {
        return URI::class;        
    } 

    public function create(): Entity
    {
        (object) $queryParametersFactory = new QueryParametersFromStringFactory;

        (object) $uriForCurrentRequestFactory = new OverloadedEntitiesFactory(_(
            new HomePageURIFactory($queryParametersFactory),
            new PathURIFactory($queryParametersFactory)
        ));

        (object) $globalRequest = Request::createFromGlobals();
        (object) $homePath = i(wp_parse_url(get_home_url(), PHP_URL_PATH))->ensureRight('/');
        (object) $serverPath = i(
            ($globalRequest->getPathInfo() ?? $globalRequest->getRequestUri()) ?? '/'
        )->ensureRight('/');
        
        /**
         * Adjustments for when site is not installed in root (/)
         */
        if ($serverPath->startsWith($homePath)) {
            $serverPath = $serverPath->removeLeft($homePath)->replace('//', '/');
        }

        return $uriForCurrentRequestFactory->createEntity(
            _(
                wp_parse_url(
                    Request::create($serverPath->get(), parameters: $globalRequest->query->all())->getUri()
                )
            )
        );
    } 
}