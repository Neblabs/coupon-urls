<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\Original\Environment\Env;
use function CouponURLs\Original\Utilities\Collection\a;

class NoncesExporter implements DashboardExportable
{
    public function key(): string
    {
        return 'security';
    } 

    public function export(): array
    {
        return a(
            nonce: a(
                id: $id = Env::getWithPrefix('dashboard_nonce'),
                value: wp_create_nonce($id)
            )
        );
    } 
}