<?php

namespace CouponURLs\Original\Creators\Handler;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Tasks\Task;

Class HandlerRegistratorTask extends Task
{
    public function run(Collection $taskData)
    {
        (string) $eventsFile = Env::directory()."app/events/actions.php";
        (array) $registeredEvents = require $eventsFile;
        (string) $className = ucfirst($taskData->get('className'));

        $registeredEvents[$taskData->get('hookName')][] = "CouponURLs\App\\Handlers\\{$className}";

        (string) $newArray = $this->varexport($registeredEvents);

        $newArray = preg_replace("/([0-9]+\s+=>\s+)/", '', $newArray);

        file_put_contents($eventsFile, "<?php\n\nreturn {$newArray};");
    }

    protected function varexport($expression, $return=true, $indent=4) {
        $object = json_decode(str_replace(['(', ')'], ['&#40', '&#41'], json_encode($expression)), TRUE);
        $export = str_replace(['array (', ')', '&#40', '&#41'], ['[', ']', '(', ')'], var_export($object, TRUE));
        $export = preg_replace("/ => \n[^\S\n]*\[/m", ' => [', $export);
        $export = preg_replace("/ => \[\n[^\S\n]*\]/m", ' => []', $export);
        $spaces = str_repeat(' ', $indent);
        $export = preg_replace("/([ ]{2})(?![^ ])/m", $spaces, $export);
        $export = preg_replace("/^([ ]{2})/m", $spaces, $export);
        if ((bool)$return) return $export; else echo $export;
    }
}