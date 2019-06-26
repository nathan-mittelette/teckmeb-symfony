<?php

namespace Teckmeb\CoreBundle\Services;

class PasswordService {

    const PASSWORD_SIZE = 10;

    public function getRandomPassword()
    {
        // TODO changer avant la mise en prod
        return "123";
        $tabCaract = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*/-_1234567890";
        $retour = "";
        for ($i = 0; $i < self::PASSWORD_SIZE; $i++) {
            $retour = $retour . substr($tabCaract, rand(0, strlen($tabCaract)), 1);
        }
        return $retour;
    }
}