<?php

namespace App\Form;

use App\Entity\Traitement;
use App\Entity\User;
use App\Repository\ConsultationRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraitementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debut',null,['widget' => 'single_text'])
            ->add('fin',null,['widget' => 'single_text'])
            ->add('patient', EntityType::class,['choice_label' => 'tel', 'class' => User::class])
            //->add('medecin')
            ->add('type')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Traitement::class,
        ]);
    }
}
