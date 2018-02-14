<?php
namespace App\Services;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PersonalityBrain
 * @package App\Services
 */
class PersonalityBrain
{
    public function determinePersonality($resultat)
    {
        $personality =['','','',''];
        if ($resultat == 'INFP' or 'ENFP' or 'INFJ' or 'ENFJ')
        {$personality[0] ='Diplomate';}
        elseif ($resultat == 'ISTJ' or 'ESTJ' or 'ISFJ' or 'ESFJ')
        {$personality[0] ='Un Sentinelle';}
        elseif ($resultat == 'INTJ' or 'ENTJ' or 'INTP' or 'ENTP')
        {$personality[0] ='Rationnel';}
        else
        {$personality[0] ='Un Explorateur';}

        if ($resultat[0] == 'I')
        {$personality[1]='Introvertie';}
        else{$personality[1]='Extravertie';}

        if ($resultat[1] == 'N')
        {$personality[2]=' Intuitif';}
        else{$personality[2]='Capteur';}

        if ($resultat[2] == 'F')
        {$personality[3]='Empathique';}
        else{$personality[3]='Penseur';}

        if ($resultat[1] == 'J')
        {$personality[4]='Organisé';}
        else{$personality[4]='Spontané';}

        return $personality;
    }

    }


