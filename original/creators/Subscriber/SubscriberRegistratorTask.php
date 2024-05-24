<?php

namespace CouponURLs\Original\Creators\Subscriber;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Wordpress\Framework\AppBackendSubscribersSource;
use CouponURLs\Original\Events\Wordpress\Framework\AppFrontEndSubscribersSource;
use CouponURLs\Original\Events\Wordpress\Framework\AppGlobalSubscribersSource;
use CouponURLs\Original\Tasks\Task;

use function CouponURLs\Original\Utilities\Text\i;

Class SubscriberRegistratorTask extends Task
{
    protected Collection $taskData;

    public function __construct(
        protected string $hookName,
        protected string $section = 'g'
    ) {}
    
    public function run(Collection $taskData)
    {
        (string) $eventsFile = $this->getFileName($taskData);
        (array) $registeredEvents = require $eventsFile;
        (string) $className = ucfirst($taskData->get('className'));

        $registeredEvents[$this->hookName][] = $taskData->get('fullyQualifiedClassName');

        (string) $newArray = $this->varexport($registeredEvents);

        $newArray = preg_replace("/([0-9]+\s+=>\s+)/", '', $newArray);
        $import = "use function ".Env::settings()->app->namespace."\Original\Utilities\Collection\a;";
        file_put_contents($eventsFile, "<?php\n\n{$import}\n\nreturn {$newArray};");
    }

    protected function getFileName(Collection $taskData) : string
    {
        return match($taskData->get('createInOriginalDirectory')) {
            true => Env::originalDirectory().'subscribers/actions.php',
            false => match($this->section) {
                'g' => (new AppGlobalSubscribersSource)->source(),
                'f' => (new AppFrontEndSubscribersSource)->source(),
                'b' => (new AppBackendSubscribersSource)->source()
            }
        };
    }

    protected function varexport($expression, $return=true, $indent=4) {
        $object = json_decode(str_replace(['(', ')'], ['&#40', '&#41'], json_encode($expression)), TRUE);
        $export = str_replace(['array (', ')', '&#40', '&#41'], ['[', ']', '(', ')'], var_export($object, TRUE));
        $export = preg_replace("/ => \n[^\S\n]*\[/m", ' => [', $export);
        $export = preg_replace("/ => \[\n[^\S\n]*\]/m", ' => []', $export);
        $spaces = str_repeat(' ', $indent);
        $export = preg_replace("/([ ]{2})(?![^ ])/m", $spaces, $export);
        $export = preg_replace("/^([ ]{2})/m", $spaces, $export);
        $export = i($export)->replaceRegEx("/'(\w+)' =>/", '$1:')->trimLeft()->removeLeft('[')->ensureLeft('a(')->trimRight()->removeRight(']')->ensureRight(')');
        if ((bool)$return) return $export; else echo $export;
    }
}