<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\forgetType;
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
     * @Route("/login/forget", name="forget-password")
     */
    public function forgetAction(Request $request,\Swift_Mailer $mailer){

        $user = new User;
        $form = $this->createForm(forgetType::class,$user);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            // Encode the new users password if changed
            if ($form->isValid()!=true) {


                $email = $user->getEmail();
                $em = $this->getDoctrine()->getManager();

                $user = $em->getRepository("App:User")->findByEmail($email);
                $hash = rand(10000000, 99999999);
                $encoder = $this->get('security.password_encoder');
                $password = $encoder->encodePassword($user[0], $hash);
                $user[0]->setPassword($password);
                $em->persist($user[0]);
                $em->flush();
                $message = (new \Swift_Message('Hello Email'))
                    ->setFrom('datalents.contact@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'emails/forget.html.twig',
                            ['hash' => $hash,
                                'email' => $email,]
                        ),
                        'text/html'
                    );


                $mailer->send($message);
                return $this->render('emails/emailfoget.html.twig', ['email' => $email]);

            } else{
                return new Response ("email n'existe pas");
            }
        }

        return $this->render('auth/forget.html.twig', ['form' => $form->createView()]);
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
     * @Route("/mail/{hash}/{email}", name="confirmMail")
     */
    public function confirmmailAction($hash,$email, \Swift_Mailer $mailer)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("App:User")->findByEmail($email);
        $test = $user[0]->getHash();

        if ($test == $hash)
        {
            $user[0]->setIsVerified(true);
            $em->persist($user[0]);
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
            return new Response ("email non vérifier, vérifier votre boite mail");
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
