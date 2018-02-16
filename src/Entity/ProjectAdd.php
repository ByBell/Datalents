<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 13/02/2018
 * Time: 23:12
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class ProjectAdd
{
    /**
     * @ORM\Column(type="string")
     */
    private $personne;

    /**
     * @return mixed
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * @param mixed $personne
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;
    }

}