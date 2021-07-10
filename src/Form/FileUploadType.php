<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FileUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('image', FileType::class, [
                'label' => false,
                'mapped' => false, // Tell that there is no Entity to link
                'required' => true,
                'constraints' => [
                  new File([ 
                    'mimeTypes' => [ // We want to let upload only txt, csv or Excel files
                      'image/png',
                      'image/jpeg',
                      'image/jpg'
                    ],
                    'mimeTypesMessage' => "Les formats acceptés sont: jpg,png,jpeg",
                  ])
                ],
              ])

            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
