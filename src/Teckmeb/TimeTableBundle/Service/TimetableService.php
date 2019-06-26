<?php

namespace Teckmeb\TimeTableBundle\Service;

use Doctrine\ORM\EntityManager;
use Teckmeb\UserBundle\Entity\User;
use Teckmeb\TimeTableBundle\Exception\TimetableException;
use Teckmeb\TimeTableBundle\Entity\Timetable;

class TimetableService
{

    protected $doctrine;
    protected $colorService;

    public function __construct(EntityManager $doctrine, $colorService)
    {
        $this->doctrine = $doctrine;
        $this->colorService = $colorService;
    }

    private function getRepository()
    {
        return $this->doctrine->getRepository("TeckmebTimeTableBundle:Timetable");
    }

    public function getTimetableFromUser(User $user)
    {
        return $this->getRepository()->findOneByUser($user);
    }

    public function initTimetable()
    {
        return new Timetable();
    }

    public function updateRessourceFromUrl(Timetable $timetable, $flush = true)
    {
        $url = $timetable->getResource();
        // On récupère les differents paramêtres de l'url notamment resources qui nous intéresse
        $arr = parse_url($url);
        $parameters = $arr["query"];
        parse_str($parameters, $data);
        // Si l'attribut resources n'existe pas on créer une erreur sinon on l'enregistre
        if (isset(($data['resources']))) {
            $resource = $data['resources'];
        } else {
            throw new TimetableException("Erreur dans l'url");
        }
        $timetable->setResource($resource);
        // On ajout l'objet timetable à la base de donnée
        $this->doctrine->persist($timetable);
        if ($flush)
            $this->doctrine->flush();
    }

    public function getUrlFromTimetable(Timetable $timetable, $dateDebut, $dateFin)
    {
        return "http://adelb.univ-lyon1.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=" . $timetable->getResource() . "&projectId=2&calType=ical&firstDate=" . $dateDebut->format('Y-m-d') . "&lastDate=" . $dateFin->format('Y-m-d');
    }

    public function getOtherDate($dateDebut) {
        // Création des variables pour permettre de changer de semaine
        $datePrec = new \DateTime($dateDebut->format('Y-m-d') . '-7day');
        $dateSuiv = new \DateTime($dateDebut->format('Y-m-d') . '+7day');
        return array($datePrec , $dateSuiv);
    }

    public function getTimetableFromDate($timetable, $periodeEDT, $isDashboard = false)
    {
        $dateDebut = $periodeEDT->getDateDebut();
        $dateFin = $periodeEDT->getDateFin();
        // On récupère le décalage horaire
        $dateDebut->setTimezone(new \DateTimeZone('Europe/Paris'));
        $adaptHoraire = $dateDebut->getOffset() / 3600;
        // On récupère le fichier ics contenant les cours grâce à la resource et a une date de début et de fin
        $url = $this->getUrlFromTimetable($timetable, $dateDebut, $dateFin);
        $calendar = file_get_contents($url);
        // On défini tous les REGEX utilisé pour parcourir le fichier et récupérer les infos voulu
        $regExpCours = '/SUMMARY:(.*)/';
        $regExpDate = '/DTSTART:(.*)/';
        $regExpDesc = '/DESCRIPTION:(.*)/';
        $regExpDateF = '/DTEND:.(.*)/';
        $regExpExport = '/\(Exporté/';
        $regExpLocation = '/LOCATION:(.*)/';
        // $n permet de savoir le nombre de cours est présent et grâce a preg_match_all on récupèrer chaque contenu des cours
        $n = preg_match_all($regExpCours, $calendar, $coursTab, PREG_PATTERN_ORDER);
        preg_match_all($regExpDate, $calendar, $dateTab, PREG_PATTERN_ORDER);
        preg_match_all($regExpDesc, $calendar, $descTab, PREG_PATTERN_ORDER);
        preg_match_all($regExpDateF, $calendar, $dateFtab, PREG_PATTERN_ORDER);
        preg_match_all($regExpLocation, $calendar, $locationTab, PREG_PATTERN_ORDER);
        // Initialisation du tableau contenant chaque jour de la semaine pour trier les données reçus
        
        if($isDashboard)
        {
            $tabDays = $this->returnDayNom($dateDebut->format('w'));
            $tabDate = array();
            $tabDispo = array();
        } else {
            $tabDays = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi');
            for ($i = 0; $i < 5; $i++) {
                $date = new \DateTime($dateDebut->format('Y-m-d') . '+' . $i . 'day');
                $tabDays[$i] = $tabDays[$i] . ' ' . $date->format('d/m');
                $tabDate[$date->format('d/m')] = array();
                $tabDispo[$date->format('d/m')] = array();
            }
        }
        // On parcours tout les évènements et on créer les variables nécessaires
        for ($j = 0; $j < $n; $j++) {
            // On récupère la localisation du cours
            $location = substr($locationTab[0][$j], 9);
            $location = str_replace('\\', '', $location);
            // On récupère la date du cours
            $annee = substr($dateTab[0][$j], 8, 4);
            $mois = substr($dateTab[0][$j], 12, 2);
            $jour = substr($dateTab[0][$j], 14, 2);
            // On récupère l'heure du début du cours
            $heure = substr($dateTab[0][$j], 17, 2);
            $heure = $heure + $adaptHoraire;
            $heure = ($heure < 10) ? '0' . $heure : $heure;
            // On récupère l'heure de fin du cours
            $min = substr($dateTab[0][$j], 19, 2);
            $heureFin = substr($dateFtab[0][$j], 15, 2);
            $heureFin = $heureFin + $adaptHoraire;
            $heureFin = ($heureFin < 10) ? '0' . $heureFin : $heureFin;
            $minFin = substr($dateFtab[0][$j], 17, 2);
            // On récupère le nom du cours
            $cours = substr($coursTab[0][$j], 8);
            $cours = str_replace('\,', ',', $cours);
            // On récupère la description du cours
            $desc = substr($descTab[0][$j], 12);
            // On supprimer la fin du contenu de la variable description pour seulement récupérer la description du cours
            $tmp = mb_strripos($desc, '(');
            $desc = substr($desc, 0, $tmp);
            // On reconstitu la date du cours
            $date = $jour . '-' . $mois . '-' . $annee;
            // On calcul la durée en fonction de l'heure du début et de la fin
            $horaire = $heure . ':' . $min;
            $horaireFin = $heureFin . ":" . $minFin;
            $h1 = strtotime($heure . ":" . $min . ":00");
            $h2 = strtotime($heureFin . ":" . $minFin . ":00");
            $duree = date('H:i', $h2 - $h1);
            // On récupère le groupe
            $regex = '#G[1-9]S[1-4]#';
            $tabGroupe = array();
            $tabRetourGroupe = array();
            $p = preg_match_all($regex, $desc, $tabRetourGroupe, PREG_OFFSET_CAPTURE);
            for ($i = 0; $i < $p; $i++) {
                $tabGroupe[] = $tabRetourGroupe[0][$i][0];
            }
            if ($p > 0) {
                $desc = substr($desc, $tabRetourGroupe[0][$p - 1][1] + 4);
                $groupe = implode(' , ', $tabGroupe);
            } else {
                $groupe = explode('\n', $desc);
                if (isset($groupe[1])) {
                    $groupe = $groupe[1];
                    $desc = str_replace($groupe, '', $desc);
                } else
                    $groupe = null;
            }
            // On supprimer les caractères spécieux de la description
            $desc = str_replace('\n', ' ', $desc);
            // On récupère le numero du module
            $numModule = explode(" ", $cours)[0];

            $color = $this->colorService->getColorFromNumModule($numModule);

            $date = new \DateTime($date);
            $newHoraire = $horaire;
            // Ajout du tableau qui permet de savoir si une case est prise ou non
            for ($t = 0; $t < $this->dureeToNumeric($duree) - 1; $t++) {
                $newHoraire = $this->horaireSuiv($newHoraire);
                $tabDispo[$date->format('d/m')][$newHoraire] = true;
            }
            // On créer un nouveau format de date et on enregistre le cours dans le tableau
            $tabDate[$date->format('d/m')][$horaire] = array('HoraireDebut' => $horaire, 'HoraireFin' => $this->horaireSuiv($newHoraire), 'Cours' => $cours, 'Description' => $desc, 'Duree' => $duree, 'Location' => $location, 'Couleur' => $color, 'DureeNum' => $this->dureeToNumeric($duree), 'Groupe' => $groupe);
        }
        // Création du tableau pour afficher les horaires
        $tabHoraire = array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30");
        // On définit une nouvelle valeur pour cette variable tabColor
        $this->colorService->save();
        return array($tabDays, $tabHoraire, $tabDate, $tabDispo, $n);
    }

    public function horaireSuiv($horaire)
    {
        if (substr($horaire, -2) == "00") {
            return substr($horaire, 0, 3) . "30";
        } else {
            $return = substr($horaire, 0, 2) + 1;
            $return = ($return > 9) ? $return . ":00" : "0" . $return . ":00";
            return $return;
        }
    }

    function dureeToNumeric($duree)
    {
        $hour = substr($duree, 0, -3);
        $min = substr($duree, -2);
        return ($hour * 2) + ((int)($min / 30));
    }

    private function returnDayNom($num)
    {
        $tab = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        return $tab[$num];
    }
}
