<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\UserTraining;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{   
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        //Gestion utilisateurs
        $users = [];
        $genres = ['male','female'];

        for($i = 1; $i <= 30; $i++)
        {
            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture = "https://randomuser.me/api/portraits/";
            $pictureId = $faker->numberBetween(1,99) . '.jpg';

            $picture .= ($genre == "male" ? "men/" : "women/") . $pictureId;
            $fName = $faker->firstName($genre);
            $lName= $faker->lastName;
            $email = strtolower($fName).".".strtolower($lName). "@mail.com";

            $user->setFirstName($fName)
                 ->setLastName($lName)
                 ->setEmail($email)
                 ->setPicture($picture)
                 ->setPassword($this->encoder->encodePassword($user,'password'));

            //Gestion programme auto
         
             $training_auto = new UserTraining();

            $level = ["Debutant","Intermediaire","Confirmé"];
            $frequency = ["1","2","3"];
            $type = ["PDC", "Machine"];
            $city = ["Paris", "Bordeaux", "Lyon","Lille","Marseille"];

           // $user = $users[mt_rand(0, count($users) - 1)];

             $training_auto->setTrainingLevel($level[mt_rand(0,2)])
                           ->setTrainingFrequency($frequency[mt_rand(0,2)])
                           ->setTrainingType($type[mt_rand(0,1)])
                           ->setUser($user)
                           ->setCity($city[mt_rand(0,4)]);

            $manager->persist($training_auto);
         

            $manager->persist($user);
            $users[] = $user;
        }

         $manager->flush();

    }
       


}
