<?php

namespace Teckmeb\ModuleBundle\Model;

class ListOption
{

    public $listOption;

    public function __construct($listOption)
    {
        $this->listOption = $listOption;
    }

    public function __get($nom)
    {
        if (\preg_match("#^value[0-9]+$#", $nom) > 0) {
            $i = str_replace("value", "", $nom);
            if ($i >= 0 && $i < count($this->listOption)) {
                return $this->listOption[$i]->getValue();
            }
        } else {
            echo "Erreur : " . $nom;
        }
    }

    public function __set($nom, $value)
    {
        if (\preg_match("#^value[0-9]+$#", $nom) > 0) {
            $i = str_replace("value", "", $nom);
            if ($i >= 0 && $i < count($this->listOption)) {
                $this->listOption[$i]->setValue($value);
            }
        } else {
            echo "Erreur : " . $nom;
        }
    }
}
