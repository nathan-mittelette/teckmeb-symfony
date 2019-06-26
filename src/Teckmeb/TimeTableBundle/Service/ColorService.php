<?php

namespace Teckmeb\TimeTableBundle\Service;

class ColorService
{
    public $colorTab;
    public $tabColor;
    protected $session;

    public function __construct($requestObj)
    {
        $this->session = $requestObj->getCurrentRequest()->getSession();
        $this->tabColor = $this->session->get('tabColor');
        $tmp = $this->session->get('colorTab');
        if (($tmp != null) && (count($tmp) != 0)) {
            $this->setColorTab($tmp);
        } else {
            $this->setColorTab(array(
                '#f44336', '#d50000', '#e91e63', '#c51162', '#9c27b0', '#aa00ff', '#673ab7', '#6200ea', '#3f51b5', '#304ffe', '#2196f3', '#2962ff', '#03a9f4', '#0091ea', '#00bcd4', '#00b8d4', '#009688', '#00bfa5', '#4caf50', '#00c853', '#8bc34a', '#64dd17', '#cddc39', '#aeea00', '#ffeb3b', '#ffd600', '#ffc107', '#ffab00', '#ff9800', '#ff6d00', '#ff5722', '#dd2c00', '#795548', '#9e9e9e', '#607d8b'
            ));
        }
        if ($this->tabColor === null)
            $this->tabColor = array();
    }

    public function save() {
        $this->session->set("tabColor" , $this->tabColor);
        $this->session->set("colorTab" , $this->colorTab);
    }

    public function getColorTab()
    {
        return $this->colorTab;
    }

    public function setColorTab($colorTab)
    {
        $this->colorTab = $colorTab;
    }

    public function getRandomColor()
    {
        $chiffreTab = "0123456789abcdef";
        if (count($this->colorTab) == 0) {
            for ($i = 0; $i < 9; $i++) {
                $color = "#";
                for($index = 0; $index < 6; $index++)
                {
                    $color = $color . $chiffreTab[rand(0,15)];
                }
                $this->colorTab[] = $color;
            }
            $this->colorTab = array_values($this->colorTab);
        }
        $min = 0;
        $max = count($this->colorTab) - 1;
        $nbColor = rand($min, $max);
        $Color = $this->colorTab[$nbColor];
        unset($this->colorTab[$nbColor]);
        $this->setColorTab(array_values($this->colorTab));
        return $Color;
    }

    public function getColorFromNumModule($numModule)
    {
        if (!(isset($this->tabColor[$numModule]))) 
            $this->tabColor[$numModule] = $this->getRandomColor();
        return $this->tabColor[$numModule];
    }
}
