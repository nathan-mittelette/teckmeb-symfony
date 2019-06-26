<?php

namespace Teckmeb\TimeTableBundle\Exception;

use Symfony\Component\Config\Definition\Exception\Exception;

class TimetableException extends Exception
{

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}
