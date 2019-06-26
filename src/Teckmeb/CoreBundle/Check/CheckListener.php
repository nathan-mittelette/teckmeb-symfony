<?php

namespace Teckmeb\CoreBundle\Check;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class CheckListener
{
    protected $check;

    public function __construct(CheckService $check)
    {
        $this->check = $check;
    }

    public function processCheck(FilterControllerEvent $event)
    {
        if($event->isMasterRequest())
            $this->check->rightToController($event->getController()[0]);
    }
}
