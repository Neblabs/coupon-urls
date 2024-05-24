<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Components\Actions\Builtin\AddProductComponent;
use CouponURLs\App\Components\Actions\Builtin\RedirectionComponent;
use CouponURLs\App\Components\Components;
use CouponURLs\App\Components\Exporters\Dashboard\ActionsDashboardExporter;
use CouponURLs\App\Components\Exporters\Dashboard\Actions\ActionComponentsExporter;
use CouponURLs\App\Components\Exporters\Dashboard\DahsboardURLsExporter;
use CouponURLs\App\Components\Exporters\Dashboard\DashboardComponentsExporter;
use CouponURLs\App\Components\Exporters\Dashboard\NoncesExporter;
use CouponURLs\App\Components\Exporters\Dashboard\OptionsExporter;
use CouponURLs\App\Components\Exporters\Dashboard\PreloadedDataExporter;
use CouponURLs\App\Components\Exporters\Dashboard\QueryParametersDashboardExporter;
use CouponURLs\App\Components\Exporters\Dashboard\StateExporter;
use CouponURLs\App\Components\Exporters\Dashboard\TextDomainExporter;
use CouponURLs\App\Components\Exporters\Dashboard\URIComponentsExporter;
use CouponURLs\App\Components\Exporters\Dashboard\URIDashboardExporter;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Dashboard\DashboardData;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use function CouponURLs\Original\Utilities\Collection\_;

class DashboardDataDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;

    public function __construct(
        protected Components $actionComponents,
        protected AddProductComponent $addProductComponent,
        protected RedirectionComponent $redirectionComponent,
        protected QueryParametersFromStringFactory $queryParametersFromStringFactory,
    ) {}
    
    static public function type(): string
    {
        return DashboardData::class;
    } 

    public function create(): DashboardData
    {
        return new DashboardData(_(
            new DashboardComponentsExporter(_(
                new ActionComponentsExporter(
                    $this->actionComponents
                ),
                new URIComponentsExporter
            )),
            new TextDomainExporter,
            new DahsboardURLsExporter,
            new StateExporter(_(
                new QueryParametersDashboardExporter($this->queryParametersFromStringFactory),
                new URIDashboardExporter,
                new ActionsDashboardExporter($this->actionComponents),
                new OptionsExporter
            )),
            new PreloadedDataExporter(
                $this->addProductComponent,
                $this->redirectionComponent
            ),
            new NoncesExporter
        ));
    } 
}