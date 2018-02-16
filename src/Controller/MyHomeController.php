<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 10/02/2018
 * Time: 00:30
 */

namespace App\Controller;

use App\Form\AddPersonnesType;
use App\Form\EditUserType;
use App\Form\ResultAddProjectType;
use App\Entity\ProjectAdd;
use App\Form\AddPhotoProjectType;
use App\Entity\PersonalityTest;
use App\Form\AddProjectType;
use App\Form\Add2ProjectType;
use App\Entity\Project;
use App\Form\PersonalityTestType;
use App\Form\ProfileType;
use App\Services\PersonalityBrain;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    {   $em = $em = $this->getDoctrine()->getManager();
        $profile= $user->getProfile();
        $projects = $profile->getProjects();
        $project =$projects[0];
        if ($project != null){




        if ($project->getEmailPersonne1() != null) {
            $personne1 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne1()])->getProfile();
        } else {
            $personne1 = null;
        }
        if ($project->getEmailPersonne2() != null) {
            $personne2 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne2()])->getProfile();
        } else {
            $personne2 = null;
        }
        if ($project->getEmailPersonne3() != null) {
            $personne3 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne3()])->getProfile();
        } else {
            $personne3 = null;
        }
        if ($project->getEmailPersonne4() != null) {
            $personne4 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne4()])->getProfile();
        } else {
            $personne4 = null;
        }

    }
    else{
            $project = null;
            $personne1=null;
        $personne2=null;
        $personne3=null;
        $personne4=null;
    }
        if ($em->getRepository('App:User')->find(1)->getProfile() != null)
        {$profile1 = $em->getRepository('App:User')->find(1)->getProfile();}
        else{$profile1==null;}
        if ($em->getRepository('App:User')->find(2)->getProfile() != null)
        {$profile2 = $em->getRepository('App:User')->find(2)->getProfile();}
        else{$profile2==null;}
        if ($em->getRepository('App:User')->find(3)->getProfile() != null)
        {$profile3 = $em->getRepository('App:User')->find(3)->getProfile();}
        else{$profile3==null;}


        return $this->render('myhome/home.html.twig', ['user' => $user,'profile'=>$profile,'project'=>$project, 'personne1'=>$personne1, 'personne2'=>$personne2, 'personne3'=>$personne3, 'personne4'=>$personne4,'profile1'=>$profile1,'profile2'=>$profile2,'profile3'=>$profile3]);
    }

    /**
     * @Route("/home/profile", name="myprofile")
     */
    public function profileAction( UserInterface $user)
    {

    $id= $user->getProfile()->getId();
        return $this->redirectToRoute('profile',['id'=>$id]);

    }

    /**
     * @Route("/home/edit_profile", name="edit_profile")
     * @param Request $request
     * @param UserInterface $user
     * @return Response
     */
    public function editProfileAction(Request $request, UserInterface $user){
        $userProfile = $user->getProfile();
        $form = $this->createForm(ProfileType::class, $userProfile, [
            'method' => 'PATCH'
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($userProfile);
            $em->flush();
        }

        return $this->render('myhome/edit_profile.html.twig', ['form' => $form->createView(), 'profile' => $userProfile]);
    }

    /**
     * @Route("/home/edit_account", name="edit_account")

     */
    public function editAccountAction(Request $request, UserInterface $user){

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
            $project->setFinish(false);
            $project->setPhoto('/img/profil_hero_bg.png');
            $project->setCreatorId($user->getEmail());
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
        if ($projects[0] == null){
            return $this->redirectToRoute('add-project');
        }
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
            $personne4[$i] = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne4()])->getProfile();
        } else {
            $personne4[$i] = null;
        }
        $i=$i+1;
        }
        return $this->render('myhome/myproject.html.twig', ['projects' => $projects,'personne1'=>$personne1,'personne2'=>$personne2,'personne3'=>$personne3,'personne4'=>$personne4]);
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
        $user->getProfile()->addProject($project);
        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('view-project', ['id' => $id]);
    }

    /**
     * @Route("/home/project/all", name="project")
     */
    public function projectAction(Request $request, SessionInterface $session, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('App:Project')->findByFinish(false);
        $i=1;
        foreach ($projects as $project){
            $profile[$i] = $em->getRepository('App:user')->findOneBy(['email' => $project->getCreatorId()])->getProfile();
            $i=$i+1;
        }

        return $this->render('myhome/project.html.twig', ['projects' => $projects, 'profile' => $profile]);
    }

    /**
     * @Route("/home/project/{id}", name="view-project")
     */
    public function viewprojectAction($id, Request $request, SessionInterface $session, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('App:Project')->find($id);
        $i=1;
        $profile = $em->getRepository('App:user')->findOneBy(['email' => $project->getCreatorId()])->getProfile();
        if ($project->getEmailPersonne1() != null) {
            $personne1 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne1()])->getProfile();
        } else {
            $personne1= null;
        }
        if ($project->getEmailPersonne2() != null) {
            $personne2 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne2()])->getProfile();
        } else {
            $personne2 = null;
        }
        if ($project->getEmailPersonne3() != null) {
            $personne3 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne3()])->getProfile();
        } else {
            $personne3= null;
        }
        if ($project->getEmailPersonne4() != null) {
            $personne4 = $em->getRepository('App:User')->findOneBy(['email' => $project->getEmailPersonne4()])->getProfile();
        } else {
            $personne4= null;
        }
        if ($project->getCreatorId() == $user->getEmail()){
            $creator=true;
        } else{
            $creator=false;
        }


        return $this->render('myhome/projectid.html.twig', ['project' => $project,'personne1'=>$personne1,'personne2'=>$personne2,'personne3'=>$personne3,'personne4'=>$personne4,'profile'=>$profile, 'creator'=>$creator]);
    }
    /**
     * @Route("/home/project/{id}/photo", name="add-photo-project")
     */
    public function addPhotoProject($id, Request $request, SessionInterface $session, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('App:Project')->find($id);

        $form = $this->createForm(AddPhotoProjectType::class, $project);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $file = $project ->getPhoto();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName);

            $project->setPhoto('/uploads/project/'.$fileName);
            $em->persist($project);
            $em->flush();
            $session->set('project_id', $project->getId());

            return $this->redirectToRoute('view-project', ['id'=> $project->getId()]);
        }


        return $this->render('myhome/AddPhotoProject.html.twig', ['form' => $form->createView(),'project'=>$project]);



    }

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


    /**
     * @Route("/home/project/delete/{id}", name="delete-project")
     */
    public function deleteProject($id, Request $request, SessionInterface $session, UserInterface $user)
    {




        return $this->redirectToRoute('view-project',['id'=>$id]);
    }
    /**
     * @Route("/home/project/{id}/finish", name="finish-project")
     */
    public function finishProject($id, Request $request, SessionInterface $session, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('App:Project')->find($id);
        $projects->setFinish(true);
        $em->persist($projects);
        $em->flush();


        return $this->redirectToRoute('view-project',['id'=>$id]);;
    }

    /**
     * @Route("/home/search", name="search")
     */
    public function searchAction(Request $request){
        $query = $request->get('q');

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('App:UserProfile')->search($query);

        return $this->render('myhome/search.html.twig', ['results' => $results, 'query' => $query]);
    }

    /**
     * @Route("/home/project/add/{id}/{personne}", name="add-talent-project")
     */
    public function addpersonneAction($id, $personne, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('App:Project')->find($id);
        $addproject = new ProjectAdd();

        $form = $this->createForm(AddPersonnesType::class, $addproject);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $em->getRepository('App:user')->findByEmail($addproject->getPersonne());
            if ($utilisateur != null)
            {
                if ($personne == 'personne1') {
                    $project->setEmailPersonne1($addproject->getPersonne());
                } elseif ($personne == 'personne2') {
                    $project->setEmailPersonne2($addproject->getPersonne());
                } elseif ($personne == 'personne3') {
                    $project->setEmailPersonne3($addproject->getPersonne());
                } elseif ($personne == 'personne4') {
                    $project->setEmailPersonne4($addproject->getPersonne());
                }

            }
            $utilisateur[0] -> getProfile()->addProject($project);
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('view-project', ['id'=> $project->getId()]);
        }


        return $this->render('myhome/AddPersonnesProject.html.twig', ['form' => $form->createView(),'project'=>$project]);
    }

    /**
     * @Route("/home/all", name="profiles")
     */
    public function allProfilesAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('App:UserProfile')->findAll();

        return $this->render('myhome/all_profiles.html.twig', ['results' => $results]);
    }


    /**
     * @Route("/home/profile/{id}", name="profile")
     */
    public function getProfileAction($id, Request $request, PersonalityBrain $personalityBrain,UserInterface $user){
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository('App:UserProfile')->find($id);


        if(empty($profile)){
            throw new NotFoundHttpException("Profil inexistant");
        }

        $personality = null;
        if(!empty($profile->getPersonality())) {
            $personality = $personalityBrain->determinePersonality($profile->getPersonality());
        }

        return $this->render('myhome/profile.html.twig', ['profile' => $profile, 'personality' => $personality]);

    }
}
