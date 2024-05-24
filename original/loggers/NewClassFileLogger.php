<?php

namespace CouponURLs\Original\Loggers;

use League\CLImate\CLImate;

Class NewClassFileLogger
{
    protected $absoluteFilePath;
    protected $className;
    protected $baseClassName;

    public function __construct(string $absoluteFilePath, string $className, string $baseClassName = '')
    {
        $this->absoluteFilePath = $absoluteFilePath;
        $this->className = $className;
        $this->baseClassName = $baseClassName;
    }
    
    public function log()
    {
        (object) $climate = new CLImate;

        $climate->out(' ');
        $climate->tab('  ');
        $climate->backgroundBlue()->bold()->blink()->inline(' NEW! ');
        $climate->lightBlue()->inline(" {$this->baseClassName}: ");
        $climate->blue()->bold()->line($this->className);
        $climate->darkGray()->out("               {$this->absoluteFilePath}");
        $climate->tab(' ')->darkGray()->dim()->underline()->inline(str_pad(' ', strlen($this->absoluteFilePath)-8));
        $climate->out("\n");
    }
}