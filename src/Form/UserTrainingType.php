<?php

namespace App\Form;

use App\Entity\UserTraining;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserTrainingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TrainingFrequency',ChoiceType::class,[
                'choices' => [
                    '1 fois / semaine' => "1",
                    '2 fois / semaine' => "2",
                    '3 fois / semaine' => "3",
                    '4 fois / semaine' => "4",
                    '5 fois / semaine' => "5",
                    
                ]
            ])
            ->add('TrainingLevel',ChoiceType::class,[
                'choices' => [
                    'Debutant' => 'Debutant',
                    'Intermediaire' => 'Intermediaire',
                    'Confirmé' => 'Confirmé',
                ]
            ])
            ->add('TrainingType',ChoiceType::class,[
                'choices' => [
                    'Poid de corps' => 'PDC',
                    'Machine' => 'Machine',
                ]
            ])
            ->add('city',TextType::class,$this->getConfig("Ville", "Entrez la ville où vous résidez"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserTraining::class,
        ]);
    }
}
