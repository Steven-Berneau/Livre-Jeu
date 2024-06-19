<?php

namespace App\Form;

use App\Entity\Aventure;
use App\Entity\Etape;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte_ambiance')
            ->add('libelle')
            ->add('aventureDebutee', EntityType::class, [
                'class' => Aventure::class,
                'choice_label' => 'titre','required'=>false
            ])
            ->add('aventure', EntityType::class, [
                'class' => Aventure::class,
                'choice_label' => 'titre',
            ])
            ->add('finAventure', EntityType::class, [
                'class' => Aventure::class,
                'choice_label' => 'titre','required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
        ]);
    }
}
