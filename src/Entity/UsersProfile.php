<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 */
class UsersProfile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string")
     */
    private $promo;

    /**
     * @ORM\Column(type="string")
     */
    private $tel;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Merci d'upload une image jpg")
     * @Assert\Image()
     */
    private $image;

    /**
     * @ORM\Column(type="string")
     */
    private $competence;

    /**
     * @ORM\Column(type="string")
     */
    private $projet;

    /**
     * @ORM\Column(type="string")
     */
    private $hobby;

    /**
     * @ORM\Column(type="string")
     */
    private $disponible;

    /**
     * @ORM\Column(type="string")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string")
     */
    private $invitation;
}
