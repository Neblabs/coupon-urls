<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\App\Components\Components;
use CouponURLs\Original\Environment\Env;
use WP_Post;

use function CouponURLs\Original\Utilities\Text\i;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

class ActionsDashboardExporter implements DashboardExportableForPost
{
    public function __construct(
        protected Components $actionComponents
    ) {}
    
    public function key(): string
    {
        return 'actions';
    } 

    public function export(WP_Post $post): array
    {
        (object) $allPostMeta = _(get_post_meta(
            post_id: $post->ID,
        ));

        // this is a shameless copy of the actions factory!
        // this code should not be duplicated but the deadline doesn't allow to actually
        // refactor the factories
        // this needs to be refactored so that both the ActionsFactory and this exporter use another factory (the same) but this will have to do the trick until i have time, if i have...
        // the thing is, this is supposed to be a quick plugin (but safe & reliable)
        // i can't spend too much time on the design even though i wish
        // but if i keep refactoring here and there i'll never release it
        (object) $onlyActionsData = fn(array $values, string $key) => i($key)->startsWith(Env::getWithPrefix('action'));

        (object) $actionsdata = $allPostMeta->filter($onlyActionsData);

        return $actionsdata->map(fn(array $values, string $key) => a(
            type: i($key)->removeLeft(Env::getWithPrefix('action_'))->get(),
            options: i($values[0] ?? '{}')->import()
        ))->getValues()->asArray();
    } 
}