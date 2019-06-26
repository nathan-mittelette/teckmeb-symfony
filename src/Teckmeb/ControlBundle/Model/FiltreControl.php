<?php

namespace Teckmeb\ControlBundle\Model;

use Teckmeb\ControlBundle\Entity\ControlType;
use Teckmeb\CoreBundle\Entity\Subject;
use Teckmeb\CoreBundle\Entity\Groupe;

class FiltreControl {
    
    public $subject = null;
    public $groupe = null;
    public $typeControl = null;

    public function getAll()
    {
        return array(($this->subject != null) ? $this->subject : null, ($this->groupe != null) ? $this->groupe : null, ($this->typeControl != null) ? $this->typeControl : null);
    }

    public function setTypeControl(ControlType $typeControl)
    {
        $this->typeControl = $typeControl;
    }

    public function getTypeControl()
    {
        return $this->typeControl;
    }

    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setGroupe(Groupe $groupe)
    {
        $this->groupe = $groupe;
    }

    public function getGroupe()
    {
        return $this->groupe;
    }
}