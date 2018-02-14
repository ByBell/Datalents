<?php
/**
 * Created by PhpStorm.
 * User: poincheval
 * Date: 13/02/2018
 * Time: 20:17
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

class PersonalityTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question1', ChoiceType::class, array(
                'label' => 'Interaction avec le monde:',
                'choices' => array( 'Je préfère travailler seul ou en petit comité avec un rythme de travail rigoureux mais constant.
                 Je préfère me concentrer sur une tâche à la fois.'=> 'I',
                                    'Je préfère travailler en groupe, cela me motive. J\'ime travailler sur  de nombreuses tâches. 
                                    J\'ai l’habitude de travailler vite et d\'être multitâche.' => 'E'),
                'expanded' => true,
                'multiple' => false,
                'required' => true))
            ->add('question2', ChoiceType::class, array(
                'label' => 'Absorption de l’information:',
                'choices' => array( 'Je suis une personne réaliste qui se concentre sur le concret. Mon sens du commun mei permet de proposer des solutions justes et réalisables.'=> 'S',
                    'J’ai une bonne vision d’ensemble. J’accorde de la valeure à l’innovation et recherche des solutions créatives aux questions posées
                                    ' => 'N'),
                'expanded' => true,
                'multiple' => false,
                'required' => true))
            ->add('question3', ChoiceType::class, array(
                'label' => 'La prise de décision:',
                'choices' => array( 'J’ai l’habitude de prendre des décisions grâce à une analyse logique du problème. J’apprécie l’honnêteté et la partialité.'=> 'T',
                    'Je suis sensible et coopératif. Je prend mes décisions en fonction de mes valeurs et de la façon dont ses décisions vont impacter le travail des autres.
                                    ' => 'F'),
                'expanded' => true,
                'multiple' => false,
                'required' => true))
            ->add('question4', ChoiceType::class, array(
                'label' => 'Organisation: ',
                'choices' => array( 'J’aime être organisé et préparé. Je préfère suivre les règles.    '
=> 'J', 'J’aime avoir le choix et à tendance à agir spontanément. Je dispose d’une grande souplesse quant à la gestion des règles.' => 'P'),
                'expanded' => true,
                'multiple' => false,
                'required' => true));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\PersonalityTest',
        ]);
    }

}

