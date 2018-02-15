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

class Add2ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


        ->add('personne1', ChoiceType::class, array(
        'choices'  => array(
            '-' => null,
            'Design' => 'Design',
            'UI' => 'UI',
            'UX' => 'UX',
            'Dev front' => 'Dev front',
            'Dev back' => 'Dev back',
            'Marketing' => 'Marketing ',
            'Data' => 'Data',
            'Référencement et optimisation' => 'Référencement et optimisation',
            'Autre' => 'Autre',

        ),'expanded' => false,
        'multiple' => false,
    ))
        ->add('personne2', ChoiceType::class, array(
            'choices'  => array(
                '-' => null,
                'Design' => 'Design',
                'UI' => 'UI',
                'UX' => 'UX',
                'Dev front' => 'Dev front',
                'Dev back' => 'Dev back',
                'Marketing' => 'Marketing ',
                'Data' => 'Data',
                'Référencement et optimisation' => 'Référencement et optimisation',
                'Autre' => 'Autre',

            ),'expanded' => false,
            'multiple' => false,
        ))
        ->add('personne3', ChoiceType::class, array(
            'choices'  => array(
                '-' => null,
                'Design' => 'Design',
                'UI' => 'UI',
                'UX' => 'UX',
                'Dev front' => 'Dev front',
                'Dev back' => 'Dev back',
                'Marketing' => 'Marketing ',
                'Data' => 'Data',
                'Référencement et optimisation' => 'Référencement et optimisation',
                'Autre' => 'Autre',

            ),'expanded' => false,
            'multiple' => false,
        ))
        ->add('personne4', ChoiceType::class, array(
            'choices'  => array(
                '-' => null,
                'Design' => 'Design',
                'UI' => 'UI',
                'UX' => 'UX',
                'Dev front' => 'Dev front',
                'Dev back' => 'Dev back',
                'Marketing' => 'Marketing ',
                'Data' => 'Data',
                'Référencement et optimisation' => 'Référencement et optimisation',
                'Autre' => 'Autre',

            ),'expanded' => false,
            'multiple' => false,
        ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Project',
        ]);
    }
}