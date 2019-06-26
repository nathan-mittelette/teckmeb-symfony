<?php 

namespace Teckmeb\TimeTableBundle\Model;

class PeriodeEDT {
    private $dateDebut;
    private $dateFin;

    public function __construct($dateDebut , $dateFin)
    {
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function setDateDebut($dateDebut) {
        $this->dateDebut = $dateDebut;
    }

    public function setDateFin($dateFin) {
        $this->dateFin = $dateFin;
    }

    public function getDateDebut() {
        return $this->dateDebut;
    }

    public function getDateFin() {
        return $this->dateFin;
    }
}