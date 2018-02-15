<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 *
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;


    /**
     * @ORM\Column(type="string")
     */
    private $equipes;


    /**
     * @return mixed
     */
    public function getEquipes()
    {
        return $this->equipes;
    }


    /**
     * @param mixed $equipes
     */
    public function setEquipes($equipes)
    {
        $this->equipes = $equipes;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return mixed
     */
    public function getPersonne1()
    {
        return $this->personne1;
    }

    /**
     * @param mixed $personne1
     */
    public function setPersonne1($personne1)
    {
        $this->personne1 = $personne1;
    }

    /**
     * @return mixed
     */
    public function getPersonne2()
    {
        return $this->personne2;
    }

    /**
     * @param mixed $personne2
     */
    public function setPersonne2($personne2)
    {
        $this->personne2 = $personne2;
    }

    /**
     * @return mixed
     */
    public function getPersonne3()
    {
        return $this->personne3;
    }

    /**
     * @param mixed $personne3
     */
    public function setPersonne3($personne3)
    {
        $this->personne3 = $personne3;
    }

    /**
     * @return mixed
     */
    public function getPersonne4()
    {
        return $this->personne4;
    }

    /**
     * @param mixed $personne4
     */
    public function setPersonne4($personne4)
    {
        $this->personne4 = $personne4;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $personne1;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $personne2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $personne3;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $personne4;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailpersonne1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailpersonne2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailpersonne3;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailpersonne4;

    /**
     * @return mixed
     */
    public function getEmailpersonne1()
    {
        return $this->emailpersonne1;
    }

    /**
     * @param mixed $emailpersonne1
     */
    public function setEmailpersonne1($emailpersonne1)
    {
        $this->emailpersonne1 = $emailpersonne1;
    }

    /**
     * @return mixed
     */
    public function getEmailpersonne2()
    {
        return $this->emailpersonne2;
    }

    /**
     * @param mixed $emailpersonne2
     */
    public function setEmailpersonne2($emailpersonne2)
    {
        $this->emailpersonne2 = $emailpersonne2;
    }

    /**
     * @return mixed
     */
    public function getEmailpersonne3()
    {
        return $this->emailpersonne3;
    }

    /**
     * @param mixed $emailpersonne3
     */
    public function setEmailpersonne3($emailpersonne3)
    {
        $this->emailpersonne3 = $emailpersonne3;
    }

    /**
     * @return mixed
     */
    public function getEmailpersonne4()
    {
        return $this->emailpersonne4;
    }

    /**
     * @param mixed $emailpersonne4
     */
    public function setEmailpersonne4($emailpersonne4)
    {
        $this->emailpersonne4 = $emailpersonne4;
    }


}
