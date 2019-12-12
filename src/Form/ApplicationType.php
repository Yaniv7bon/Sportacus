<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
     /**
     * Permet d'obtenir la configuration de base d'un champ de formulaire
     *
     * @param array $options
     * @param string $label
     * @param string $placeholder
     * @return Array
     */
    protected function getConfig(String $label, String  $placeholder,array $options =[]): array
    {
        return array_merge_recursive([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ],$options);
    }
}