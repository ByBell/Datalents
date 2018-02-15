<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 10/02/2018
 * Time: 00:30
 */

namespace App\Controller;

use App\Form\EditUserType;
use App\Form\ResultAddProjectType;
use App\Entity\PersonalityTest;
use App\Form\AddProjectType;
use App\Form\Add2ProjectType;
use App\Entity\Project;
use App\Form\PersonalityTestType;
use App\Services\PersonalityBrain;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

class MyHomeController extends Controller
{
    /**
     *
     * @Route("/home", name="home")
     */
    public function homeAction(UserInterface $user)
    {
        $id = $user->getUsername();
        $em = $this->getDoctrine()->getManager();
        //Ici je vais chercher ma base de donnée UsersProfil avec l'email comme id.


        return $this->render('myhome/home.html.twig', ['email' => $id]);
    }

    /**
     * @Route("/home/profile", name="profile")
     */
    public function profileAction()
    {

        return $this->render('myhome/profile.html.twig');
    }

    /**
     * @Route("/home/account", name="account")
     */
    public function accountAction(Request $request, UserInterface $user)
    {
        $form = $this->createForm(EditUserType::class, $user, [
            'method' => 'PATCH'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password if changed
            if (null !== $password = $user->getPlainPassword()) {
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
    public function testAction(Request $request, UserInterface $user, PersonalityBrain $personalityBrain)
    {
        $test = new PersonalityTest();

        $form = $this->createForm(PersonalityTestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $resultat = $test->getQuestion1() . $test->getQuestion2() . $test->getQuestion3() . $test->getQuestion4();


            $em = $this->getDoctrine()->getManager();

            $profile = $user->getProfile();
            $profile->setPersonality($resultat);

            $em->persist($profile);
            $em->flush();

            $personality = $personalityBrain->determinePersonality($resultat);

            return $this->render('myhome/finish-test.html.twig', ['personality' => $personality]);


        }

        return $this->render('myhome/test.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/home/project/add", name="add-project")
     */
    public function addprojectAction(Request $request, SessionInterface $session, UserInterface $user)
    {

        $project = new Project();
        $form = $this->createForm(AddProjectType::class, $project);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $profile = $user->getProfile();
            $profile->addProject($project);

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            $session->set('project_id', $project->getId());

            return $this->redirectToRoute('add2-project');
        }


        return $this->render('myhome/addProject.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/home/project/add/2}", name="add2-project")
     */
    public function add2projectAction(Request $request, SessionInterface $session, UserInterface $user)
    {
        $project_id = $session->get('project_id');
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('App:Project')->findOneBy(['id' => $project_id]);
        $form2 = $this->createForm(Add2ProjectType::class, $project);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $em->persist($project);
            $em->flush();


            return $this->redirectToRoute('myproject');

        }
        return $this->render('myhome/add2Project.html.twig', ['form' => $form2->createView(), 'project' => $project]);
    }

    /**
     * @Route("/home/project", name="myproject")
     */
    public function myprojectAction(Request $request, SessionInterface $session, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $user->getProfile()->getProjects();

        $i=1;
        foreach ($projects as $project){


        if ($project->getEmailPersonne1() != null) {
            $personne1[$i] = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne1()])->getProfile();
        } else {
            $personne1[$i] = null;
        }
        if ($project->getEmailPersonne2() != null) {
            $personne2[$i] = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne2()])->getProfile();
        } else {
            $personne2[$i] = null;
        }
        if ($project->getEmailPersonne3() != null) {
            $personne3[$i] = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne3()])->getProfile();
        } else {
            $personne3[$i] = null;
        }
        if ($project->getEmailPersonne4() != null) {
            $personne3[$i] = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne4()])->getProfile();
        } else {
            $personne4[$i] = null;
        }
        $i=$i+1;
        }
        return $this->render('myhome/project.html.twig', ['projects' => $projects,'personne1'=>$personne1,'personne2'=>$personne2,'personne3'=>$personne3,'personne4'=>$personne4]);
    }

    /**
     * @Route("/project/{id}/{personne}", name="edit-project")
     */
    public function editProjectAction($id, $personne, Request $request, SessionInterface $session, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();

        $project = $em->getRepository('App:Project')->findOneBy(['id' => $id]);

        if ($personne == 'personne1') {
            $project->setEmailPersonne1($user->getEmail());
        } elseif ($personne == 'personne2') {
            $project->setEmailPersonne2($user->getEmail());
        } elseif ($personne == 'personne3') {
            $project->setEmailPersonne3($user->getEmail());
        } elseif ($personne == 'personne4') {
            $project->setEmailPersonne4($user->getEmail());
        }

        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('project', ['id' => $id]);
    }

}
