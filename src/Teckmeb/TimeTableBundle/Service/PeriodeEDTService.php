<?php

namespace Teckmeb\TimeTableBundle\Service;

use Teckmeb\TimeTableBundle\Model\PeriodeEDT;

class PeriodeEDTService
{
    public function initPeriodeEDT($date, $isDashboard = false)
    {
        if ($isDashboard) {
            $dateDebut = $this->returnDay($date);
            $dateFin = new \DateTime($dateDebut->format('Y-m-d'));
        } else {
            $dateDebut = ($date != '0000-00-00') ? $this->returnMonday(new \DateTime($date)) : $this->returnMonday(new \DateTime());
            $dateFin = new \DateTime($dateDebut->format('Y-m-d') . '+4day');
        }
        return new PeriodeEDT($dateDebut, $dateFin);
    }

    private function returnDay($date)
    {
        if ($date->format('w') > 5) {
            $dayPlus = 1 + 7 - $date->format('w');
            $dateRetour = new \DateTime($date->format('Y-m-d') . '+' . $dayPlus . 'day');
            return $dateRetour;
        } else if ($date->format('w') == 0) {
            return new \DateTime($date->format('Y-m-d') . '+ 1 day');
        } else {
            return new \DateTime($date->format('Y-m-d'));
        }
    }
    
    public function returnMonday($date)
    {
        if ($date->format('w') > 5) {
            $dayPlus = 1 + 7 - $date->format('w');
            return new \DateTime($date->format('Y-m-d') . '+' . $dayPlus . 'day');
        } else {
            $dayMoins = $date->format('w') - 1;
            return new \DateTime($date->format('Y-m-d') . '-' . $dayMoins . 'day');
        }
    }
}
