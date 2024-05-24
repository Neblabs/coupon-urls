<?php

namespace CouponURLs\Original\Creators\Tasks;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Loggers\NewClassFileLogger;
use CouponURLs\Original\Tasks\Task;

Class NewClassFileLoggerTask extends Task
{
    public function run(Collection $taskData)
    {
        (object) $consoleLogger = new NewClassFileLogger(
            $absoluteFilePath = $taskData->get('filePath'),
            $baseClassName = $taskData->get('baseClassName'),
            $className = $taskData->get('className')
        );

        $consoleLogger->log();
    }
}