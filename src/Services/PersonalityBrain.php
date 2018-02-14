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
        if ($resultat == 'INTJ' or $resultat == 'ENTJ' or $resultat ==  'INTP' or $resultat == 'ENTP')
            {$personality[0] ='Rationnel';}
        elseif ($resultat == 'INFP' or $resultat =='ENFP' or $resultat == 'INFJ' or $resultat =='ENFJ')
            {$personality[0] ='Diplomate';}
        elseif ($resultat == 'ISTJ' or $resultat =='ESTJ' or $resultat =='ISFJ' or $resultat =='ESFJ')
            {$personality[0] ='Un Sentinelle';}
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


