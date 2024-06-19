<?php

namespace App\Form;

use App\Entity\Aventure;
use App\Entity\Etape;
use App\Entity\Partie;
use App\Entity\Personnage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_partie', null, [
                'widget' => 'single_text',
            ])
            ->add('aventurier', EntityType::class, [
                'class' => Personnage::class,
                'choice_label' => 'id',
            ])
            ->add('aventure', EntityType::class, [
                'class' => Aventure::class,
                'choice_label' => 'id',
            ])
            ->add('etape', EntityType::class, [
                'class' => Etape::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partie::class,
        ]);
    }
}
