<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 10/02/2018
 * Time: 00:30
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class MyHomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function homeAction(UserInterface $user)
    {
        $id = $user ->getUsername();

        return $this->render('myhome/home.html.twig',['email'=>$id]);
    }
}