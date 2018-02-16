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


class AddPhotoProjectType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('photo', FileType::class, [
                'required' => false,
                'data_class' => null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Project'
        ]);
    }

}