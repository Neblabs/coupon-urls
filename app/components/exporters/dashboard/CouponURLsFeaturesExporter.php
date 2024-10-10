<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;

use function CouponURLs\Original\Utilities\Collection\a;

class CouponURLsFeaturesExporter implements DashboardExportable
{
    public function key(): string
    {
        return 'features';
    } 

    public function export(): array
    {
        return a(
            buttons: a(
                /**
                 * Use of filters might change
                 */
                dashboardLauncher: apply_filters('cu.dashboardLauncher.isEnabled', true),
                saveButton: apply_filters('cu.saveButton.isEnabled', true),
                backButton: apply_filters('cu.backButton.isEnabled', true)
            )
        );
    } 
}