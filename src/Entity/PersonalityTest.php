<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 13/02/2018
 * Time: 23:12
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class PersonalityTest
{
    /**
     * @return mixed
     */
    public function getQuestion1()
    {
        return $this->question1;
    }

    /**
     * @param mixed $question1
     */
    public function setQuestion1($question1)
    {
        $this->question1 = $question1;
    }

    /**
     * @return mixed
     */
    public function getQuestion2()
    {
        return $this->question2;
    }

    /**
     * @param mixed $question2
     */
    public function setQuestion2($question2)
    {
        $this->question2 = $question2;
    }

    /**
     * @return mixed
     */
    public function getQuestion3()
    {
        return $this->question3;
    }

    /**
     * @param mixed $question3
     */
    public function setQuestion3($question3)
    {
        $this->question3 = $question3;
    }

    /**
     * @return mixed
     */
    public function getQuestion4()
    {
        return $this->question4;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $question4
     */
    public function setQuestion4($question4)
    {
        $this->question4 = $question4;
    }
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     */
    private $question1;

    /**
     * @ORM\Column(type="string")
     */
    private $question2;

    /**
     * @ORM\Column(type="string")
     */
    private $question3;

    /**
     * @ORM\Column(type="string")
     */
    private $question4;

}