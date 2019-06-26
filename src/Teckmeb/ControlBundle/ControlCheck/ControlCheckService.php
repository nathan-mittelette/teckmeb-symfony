<?php

namespace Teckmeb\ControlBundle\ControlCheck;

use Doctrine\ORM\EntityManager;
use Teckmeb\ControlBundle\Entity\Control;

class ControlCheckService
{
    public $doctrine;

    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function updateControlAverages(Control $control, $flush = false)
    {
        $repository = $this->doctrine->getRepository('TeckmebMarkBundle:Mark');
        $listMark = $repository->findByControl($control);
        $sommeNote = 0;
        $sommeDiviseur = 0;
        $sommeEcartType = 0;
        foreach ($listMark as $mark) {
            $sommeNote += $mark->getValue();
            $sommeDiviseur += $control->getDivisor();
        }
        echo $sommeNote;
        if ($sommeNote != 0) {
            $moyenne = ($sommeNote / $sommeDiviseur) * $control->getDivisor();
            $control->setMedian($moyenne);
            foreach ($listMark as $mark) {
                $sommeEcartType += pow(($mark->getValue() - $moyenne), 2);
            }
            $variance = ($sommeEcartType / $sommeDiviseur) * $control->getDivisor();
            $ecartType = sqrt($variance);
            $control->setAverage($ecartType);
            $this->doctrine->persist($control);
            if ($flush) {
                    $this->doctrine->flush();
                }
        }
    }
}
