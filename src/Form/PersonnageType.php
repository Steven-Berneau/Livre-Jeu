<?php

namespace App\Form;

use App\Entity\Avatar;
use App\Entity\Personnage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom',NULL,['label_attr'=>['class'=>'text-warning']])
            ->add('nom',NULL,['label_attr'=>['class'=>'text-warning']])
            ->add('avatar',NULL,['label_attr'=>['class'=>'text-warning']], EntityType::class, [
                'class' => Avatar::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}
