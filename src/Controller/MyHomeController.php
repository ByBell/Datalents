<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 10/02/2018
 * Time: 00:30
 */

namespace App\Controller;

use App\Form\EditUserType;
use App\Entity\PersonalityTest;
use App\Entity\User;
use App\Form\PersonalityTestType;
use App\Services\PersonalityBrain;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class MyHomeController extends Controller
{
    /**
     *
     * @Route("/home", name="home")
     */
    public function homeAction(UserInterface $user)
    {
        $id = $user ->getUsername();
        $em = $this->getDoctrine()->getManager();
       //Ici je vais chercher ma base de donnée UsersProfil avec l'email comme id.


        return $this->render('myhome/home.html.twig', ['email' => $id]);
    }

    /**
     * @Route("/home/profile", name="profile")
     */
    public function profileAction(){
        return $this->render('myhome/profile.html.twig');
    }

    /**
     * @Route("/home/account", name="account")
     */
    public function accountAction(Request $request, UserInterface $user){
        $form = $this->createForm(EditUserType::class, $user, [
            'method' => 'PATCH'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password if changed
            if(null !== $password = $user->getPlainPassword()){
                $encoder = $this->get('security.password_encoder');
                $password = $encoder->encodePassword($user, $password);
                $user->setPassword($password);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('myhome/account.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param string $resultat du test de personalité
     * @return Response
     * @Route("/home/test", name="test")
     */
    public function testAction(Request $request, UserInterface $user, PersonalityBrain $personalityBrain){
        $test = new PersonalityTest();

        $form = $this->createForm(PersonalityTestType::class,$test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $resultat = $test->getQuestion1().$test->getQuestion2().$test->getQuestion3().$test->getQuestion4();


            $em = $this->getDoctrine()->getManager();

            $user->setPersonality($resultat);
            $em->persist($user);
            $em->flush();


            $personality = $personalityBrain->determinePersonality($resultat);

            return $this->render('myhome/finish-test.html.twig', ['personality'=>$personality]);


        }

        return $this->render('myhome/test.html.twig', ['form' => $form->createView()]);

    }


}