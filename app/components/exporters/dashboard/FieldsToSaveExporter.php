<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Characters\StringManager;

class FieldsToSaveExporter implements DashboardExportable
{
    public function key(): string
    {
        return 'fields';
    } 

    public function export(): array
    {
        return [
            'CouponURLs-event',
            'CouponURLs-conditions_root',
            'CouponURLs-recipients',
            'CouponURLs-subject',
            'CouponURLs-body'
        ];
    } 
}