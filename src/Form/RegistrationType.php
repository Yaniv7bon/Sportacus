<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfig("Prenom","Entrez votre prenom"))
            ->add('lastName', TextType::class, $this->getConfig('Nom',"Entrez votre nom de famille"))
            ->add('email', EmailType::class, $this->getConfig('Email',"Entrez votre adresse email"))
            ->add('picture',UrlType::class, $this->getConfig("Photo de profil","Entrez l'url de votre avatar",[
                'required' => false
            ]))
            ->add('password', PasswordType::class, $this->getConfig("Mot de passe","Entrez un mot de passe"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfig("Confirmation mot de passe","Veuillez confirmer votre mot de passe"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

/*            ->add('city',TextType::class, $this->getConfig('Ville',"Entrez votre ville"))
            ->add('trainingLevel', TextareaType::class, $this->getConfig("Niveau d'entrainement", "Quel est votre niveau ?"))
            ->add('trainingType', TextareaType::class, $this->getConfig("Type d'entrainement", "Quel type d'entrainement souhaitez-vous ?"))
            ->add('trainingFrequency', IntegerType::class,['label' => "Fréquence d'entrainement /semaine", 'attr' => ['min' => 0,'max' => 6]])
 */