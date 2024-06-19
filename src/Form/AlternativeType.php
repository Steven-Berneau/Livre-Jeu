<?php

namespace App\Form;

use App\Entity\Alternative;
use App\Entity\Etape;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlternativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte_ambiance')
            ->add('libelle')
            ->add('etapePrecedente', EntityType::class, [
                'class' => Etape::class,
                'choice_label' => 'id',
            ])
            ->add('etapeSuivante', EntityType::class, [
                'class' => Etape::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Alternative::class,
        ]);
    }
}
