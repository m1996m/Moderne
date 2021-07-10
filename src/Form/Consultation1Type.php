<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Consultation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',null,['widget' => 'single_text'])
            ->add('autre')
            //->add('patient')
            ->add('patient',EntityType::class,['choice_label' => 'tel', 'class' => User::class])
            ->add('fumeur',ChoiceType::class, [
                'choices'  => [
                    'fumer' => null,
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
            ])
            ->add('alcoolique',ChoiceType::class, [
                'choices'  => [
                    'alcoolique' => null,
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
            ])
            ->add('diabetique',ChoiceType::class, [
                'choices'  => [
                    'diabetique' => null,
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
