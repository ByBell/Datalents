<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 14/02/2018
 * Time: 15:09
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultAddProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emailpersonne1', TextType::class)
            ->add('emailpersonne2', TextType::class)
            ->add('emailpersonne3', TextType::class)
            ->add('emailpersonne4', TextType::class)

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Project',
        ]);
    }
}