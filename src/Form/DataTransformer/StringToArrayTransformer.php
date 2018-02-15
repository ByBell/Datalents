<?php
// src/Form/DataTransformer/IssueToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\Issue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToArrayTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param array $array
     * @return string
     */
    public function transform($array = [])
    {
        if(is_null($array)){
            $array = [];
        }

        if(!is_array($array)){
            throw new InvalidArgumentException();
        }

        return implode(';', $array);
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param $string
     * @return Issue|null
     */
    public function reverseTransform($string)
    {
        if(is_null($string)){
            $string = '';
        }

        if(!is_string($string)){
            throw new InvalidArgumentException();
        }

        return array_filter(explode(';', $string));
    }
}