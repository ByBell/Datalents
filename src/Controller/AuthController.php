<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render(
            'auth/login.html.twig',
            array(
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            )
        );
    }

    /**
     *
     * @Route("/mail/{email}/{hash}/{id}", name="mail")
     */
    public function mailAction($email,$hash,$id, \Swift_Mailer $mailer)
    {


        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('datalents.contact@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['hash'=>$hash,
                    'id'=>$id,
                    'email'=>$email,]
                ),
                'text/html'
            );


        $mailer->send($message);

        return $this->render('emails/email.html.twig');
    }


    /**
     * @Route("/mail/{id}/{hash}", name="confirmMail")
     */
    public function confirmmailAction($id,$hash, \Swift_Mailer $mailer)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("App:User")->find($id);
        $test = $user->getHash();

        if ($test == $hash)
        {
            $user->setIsVerified(true);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }
        else{
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/login/verified", name="verified")
     */
    public function verifiedAction(UserInterface $user)
    {
        $id = $user->getUsername();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("App:User")->findByEmail($id);
        $isverified = $users[0]->getisVerified();
        if ($isverified==true)
        {
            return $this->redirectToRoute('home');
        }
        else{
            return $this->redirectToRoute('login');
        }
    }



    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
    }


    //public function loginCheckAction()





    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        // Create a new blank user and process the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Set their role
            //$user->setRole('ROLE_USER');
            $user->setIsVerified(false);
            $hash = rand(10000, 99999);
            $user->setHash($hash);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();



            return $this->redirectToRoute('mail',['email'=> $user->getEmail(),'hash'=>$hash,'id'=>$user->getId()]);
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
