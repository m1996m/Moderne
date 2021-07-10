<?php

namespace App\Form;

use App\Entity\Hospilisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospilisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateAdmission')
            ->add('motifAdmission')
            ->add('nomAccompagnant')
            ->add('lien')
            ->add('dateSortie')
            ->add('statut')
            ->add('medecin')
            ->add('patient')
            ->add('motifSortie')
            ->add('chambre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hospilisation::class,
        ]);
    }
}
