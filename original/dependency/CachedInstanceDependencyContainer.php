<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Cache\Cache;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Dependency\Abilities\StaticType;

class CachedInstanceDependencyContainer extends DependencyContainer
{
    public function __construct(
        protected Dependency&StaticType $dependency,
        protected Cache $cache = new MemoryCache()
    ) {}
    
    public function get(string $type): object
    {
        return $this->cache->getIfExists('dependency')
                            ->otherwise($this->dependency->create(...));
    } 
}