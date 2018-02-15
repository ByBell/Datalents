<?php
/**
 * Created by PhpStorm.
 * User: Brendan
 * Date: 14/02/2018
 * Time: 19:22
 */

namespace App\Form;


use App\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{

    protected $stringToArrayTransformer;

    public function __construct(StringToArrayTransformer $stringToArrayTransformer)
    {
        $this->stringToArrayTransformer = $stringToArrayTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('location', TextType::class)
            ->add('photo', FileType::class, [
                'required' => false,
                'data_class' => null
            ])
            ->add('title', TextType::class)
            ->add('resume', TextareaType::class)
            ->add('skills', HiddenType::class)
            ->add( 'skill', TextType::class, [
                'mapped' => false,
                'required' => false
            ])
            ->add('hobbies', HiddenType::class)
            ->add('hobby',  TextType::class, [
                'mapped' => false,
                'required' => false
            ]);

        $builder->get('skills')->addModelTransformer($this->stringToArrayTransformer);
        $builder->get('hobbies')->addModelTransformer($this->stringToArrayTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\UserProfile',
            'allow_extra_fields' => true
        ]);
    }

}