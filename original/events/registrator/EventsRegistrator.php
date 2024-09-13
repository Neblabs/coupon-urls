<?php

namespace CouponURLs\Original\Events\Registrator;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;

Class EventsRegistrator
{
    protected $originalEvents = [];
    protected $customEvents = [];

    public function __construct()
    {
        (string) $eventsFile = 'events/actions.php';

        $this->customEvents = new Collection(
            require_once Env::directory() ."/app/{$eventsFile}"
        );

        $this->originalEvents = new Collection(
            require_once Env::directory() ."/original/{$eventsFile}"
        );
    }

    public function register()
    {
        foreach ($this->getAllEvents()->asArray() as $eventName => $eventHandlers) {
            $this->registerHandlersFor([
                'name' => (string) $eventName,
                'handlers' => (array) $eventHandlers
            ]);            
        }

        $this->callPluginLoadedEvent();
    }

    protected function callPluginLoadedEvent()
    {
        (string) $shortId = Env::shortId();
        (string) $specialEventWithPrefix = "__{$shortId}.loaded__";

        do_action($specialEventWithPrefix);
    }

    protected function registerHandlersFor(array $event)
    {
        foreach ($event['handlers'] as $handlerClass) {
            call_user_func([$handlerClass, 'register'], $event['name']);
        }
    }

    protected function getAllEvents()
    {

        (object) $events = new Collection($this->originalEvents);   

        foreach ($this->customEvents->asArray() as $event => $handlers) {
            foreach ($handlers as $handler) {
                $events->appendAsArray([$event => $handler]);
            }
        }

        return $events->mapwithKeys(function(array $handlers, string $eventName) : array  {
            return [
                'key' => $this->replacePlaceHolders($eventName),
                'value' => $handlers
            ];
        });
    }

    protected function replacePlaceHolders(string $text) : string
    {
        (object) $placeholders = new Collection([
            '(id)' => Env::id(),
            '(shortId)' => Env::shortId()
        ]);

        return str_replace(
            $placeholders->getKeys()->asArray(),
            $placeholders->getValues()->asArray(),
            $text
        );   
    }
    
}