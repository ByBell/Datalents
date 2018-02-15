<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProfileRepository")
 * @ORM\Table(indexes={@Index(columns={"firstname", "lastname", "title", "resume", "hobbies", "skills"}, flags={"fulltext"})})
 */
class UserProfile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="profile")
     */
    private $user;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="array", length=255, nullable=true)
     */
    private $skills;

    /**
     * @ORM\Column(type="array", length=255, nullable=true)
     */
    private $hobbies;

    /**
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Project")
     * @ORM\JoinTable(name="users_projects",
     *     joinColumns={
     *          @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     *     })

     */
    private $projects;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param mixed $resume
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        if(!empty($photo)){
            $this->photo = $photo;
        }
    }

    public function addProject(Project $project)
    {
        $this->projects[] = $project;
        return $this;
    }
    public function __construct()
    {
        $this->projects = new ArrayCollection();
        // ...
    }
    public function removeProject(Project $project)
    {
        $this->projects->removeElement($project);
    }

    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return mixed
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }

    /**
     * @param mixed $hobbies
     */
    public function setHobbies($hobbies)
    {
        $this->hobbies = $hobbies;
    }


    public function __toString()
    {
        return $this->getFirstname().' '.$this->getLastname();
    }

}
