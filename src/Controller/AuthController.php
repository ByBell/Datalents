<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\ResetPasswordType;
use App\Form\UserType;
use App\Form\forgetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/confirm_email/{token}", name="confirmMail")
     */
    public function confirmEmailAction($token, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("App:User")->findByEmailToken($token);

        if(!empty($user))
        {
            $user[0]->setIsVerified(true);
            $user[0]->setEmailToken(null);
            $em->persist($user[0]);
            $em->flush();

            return $this->redirectToRoute('login');
        }
        else{
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, \Swift_Mailer $mailer)
    {
        // Create a new blank user and process the form
        $userProfile = new UserProfile();
        $user = new User();
        $user->setProfile($userProfile);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setRole('ROLE_USER');
            $user->setPassword($password);
            $user->setIsVerified(false);

            // Generate token to be validated
            $token = hash('sha256', $user->getEmail().rand(0, 999));
            $user->setEmailToken($token);

            // Send message with token
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('datalents.contact@gmail.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView(
                    'mail/confirm_email.html.twig', [
                        'token' => $token
                    ]),
                    'text/html'
                );

            $mailer->send($message);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->render('auth/register_success.html.twig');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login/forgot_password", name="forget-password")
     */
    public function forgotPasswordAction(Request $request, \Swift_Mailer $mailer){

        $user = new User;
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("App:User")->findOneBy(['email' => $user->getEmail()]);

            if ($form->isValid() !== true){
                $email = $user->getEmail();
                $hash = rand(10000000, 99999999);
                $encoder = $this->get('security.password_encoder');
                $password = $encoder->encodePassword($user, $hash);
                $user->setPassword($password);
                $em->persist($user);
                $em->flush();

                $message = (new \Swift_Message('Hello Email'))
                    ->setFrom('datalents.contact@gmail.com')
                    ->setTo($email)
                    ->setBody($this->renderView('mail/forgot_password.html.twig', [
                        'hash' => $hash,
                        'email' => $email
                    ]),
                        'text/html'
                    );

                $mailer->send($message);
                return $this->render('auth/forgot_password_success.html.twig', ['email' => $email]);
            }
        }

        return $this->render('auth/forgot_password.html.twig', ['form' => $form->createView()]);
    }
}
