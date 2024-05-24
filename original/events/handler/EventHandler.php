<?php

namespace CouponURLs\Original\Events\Handler;

use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Handler\GlobalEventsValidator;
use CouponURLs\Original\Utilities\ClassName;

Abstract Class EventHandler
{
    use ClassName;

    protected $event;
    protected $numberOfArguments = 1;
    protected $priority = 10;


    //The abstract method, not defined because of the dynamic nature of hook arguments
    #abstract public function execute();
   
    public static final function register($event)
    {
        (object) $handler = new static($event);

        add_action(
            $event, 
            [$handler, 'handleEvent'],
            $handler->priority,
            $handler->numberOfArguments
        );
    }

    public function __construct()
    {
        $this->cache = new MemoryCache;
    }

    public function handleEvent(...$arguments)
    {
        (boolean) $canBeExecuted = $this->validateEventexecution();

        if ($canBeExecuted) {
            $this->execute(...$arguments);
        }
    }
    
    protected function validateEventexecution() : bool
    {
        (boolean) $canBeExecuted = true;

        if ($this->hasCustomEventsValidator()) {
            $canBeExecuted = $this->canBeExecuted();
        } elseif ($this->hasGlobalEventsValidator()) {
            (object) $globalEventsValidator = $this->getGlobalEventsValidator();

            $canBeExecuted = $globalEventsValidator->canBeExecuted();
        }

        return $canBeExecuted;
    }

    protected function hasCustomEventsValidator() : bool
    {
        return method_exists($this, 'canBeExecuted');   
    }
    
    protected function hasGlobalEventsValidator() : bool
    {
        return class_exists($this->getGlobalEventsValidatorClassName());   
    }

    protected function getGlobalEventsValidator() : GlobalEventsValidator
    {
        return $this->cache->getIfExists('globalEventsValidator')->otherwise(function() : GlobalEventsValidator {
            (string) $GlobalEventsValidator = $this->getGlobalEventsValidatorClassName();

            return new $GlobalEventsValidator;
        });   
    }

    protected function getGlobalEventsValidatorClassName() : string
    {
        return Env::settings()->events->globalValidator;
    }
            
    protected function dispatcher($method)
    {
        return [$this, $method];   
    }   
}