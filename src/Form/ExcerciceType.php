<?php

namespace App\Form;

use App\Entity\Exercices;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ExcerciceType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('groupeMusculaire',ChoiceType::class,[
                'choices' => [
                    'Bras' => 'Bras',
                    'Abdos' => 'Abdos',
                    'Dos' => 'Dos',
                    'Jambes' => 'Jambes' 
                ]
            ])
            ->add('Type',ChoiceType::class,[
                'choices' => [
                    'Poid de corps' => 'PDC',
                    'Machine' => 'Machine',
                ]
            ])
            ->add('Level',ChoiceType::class,[
                'choices' => [
                    'Debutant' => 'Debutant',
                    'Intermediaire' => 'Intermediaire',
                    'Confirmé' => 'Confirmé',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exercices::class,
        ]);
    }
}
