<?php
namespace App\Controller;


use App\Entity\User;
use App\Entity\UserTraining;
use App\Form\RegistrationType;
use App\Form\UserTrainingType;
use App\Repository\ExercicesRepository;
use App\Repository\UserTrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Gère le formulaire d'inscription
     * 
     * @Route("/register", name="account_register")
     * 
     * @return Response
     */
    public function register(EntityManagerInterface $manager,Request $request,UserPasswordEncoderInterface $encoder)
    {   
        $user = new User(); #Crée un nouvel utilisateur 
        $form = $this->createForm(RegistrationType::class,$user); #Crée formulaire d'inscription

        $form->handleRequest($request); #Permet à symfony d'affecter les infos du formulaire à l'user crée precedement 

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword()); #Encode le password avant de l'envoyer en BDD
            $user->setPassword($hash);

            $manager->persist($user); #Enregistre les modifs de l'user
            $manager->flush(); #Envoi en BDD le nouvel user créer

            $this->addFlash( 
                'success',
                'Votre compte a bien été crée ! Vous pouvez maintenant vous connectez !'
            ); #Message de succes

            return $this->redirectToRoute("account_login");
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView() #Affiche le formulaire dans twig
        ]);
    }

    /**
     * Page de connexion
     * 
     * @Route("/login", name="account_login")
     * 
     */
    public function login(AuthenticationUtils $utils) 
    {   
        #On utilise ici une classe de symfony permettant notemment
        #de recuper les erreurs ayant lieu lors d'une tentative de connexion,
        #ou enregistrant le dernier identifiant tapper
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        dump($error);

        return $this->render("account/login.html.twig",[
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Deconnexion
     * 
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout()
    {

    }
   
    /**
     * Formulaire de modification des infos sportives
     * 
     * @Route("/account/change", name="account_change")
     * 
     * 
     * @return Response
     */
    public function change(Request $request,EntityManagerInterface $manager)
    {   
        $infos = $this->getUser()->getUserTraining();
        $form = $this->createForm(UserTrainingType::class,$infos);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($infos);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre profil sportif a bien été mis à jour ! Nous allons générer un nouveau programme vous correspondant !"

            );
            return $this->redirectToRoute("training_auto");
        }

        return $this->render("account/change.html.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     * Profil utilisateur
     * 
     * @Route("/account", name="account_index")
     *
     * @return Response
     */
    public function myAccount(EntityManagerInterface $manager,Request $request)
    {   
        $infos = new UserTraining();
        $form = $this->createForm(UserTrainingType::class, $infos);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $infos->setUser($this->getUser());

            $manager->persist($infos);
            $manager->flush();

            $this->addFlash(
                'success',
                'Vos informations ont bien été enregistrées ! Nous allons générer un programme vous correspondant !'
            );
        }


        return $this->render('account/profile.html.twig',[
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }
    /**
     * Affiche page d'accueil
     * 
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function home()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * Génére un programme automatiquement en fonction des infos du formulaire
     * 
     * @Route("/account/training",name="training_auto")
     *
     * @return void
     */
    public function automaticTraining(UserTrainingRepository $repo, ExercicesRepository $repoExo)
    {
        $userParam = $repo->findOneBy(['user' => $this->getUser()->getId()]);
        dump($userParam);
        if((int)$userParam->getTrainingFrequency() <= 3)
        {
            $limit = 3;
        }else{$limit = 2;}
        $exos = $repoExo->findBy(['Type' => $userParam->getTrainingType(), 'Level' => $userParam->getTrainingLevel()],null,$limit,null);
        dump($exos);

        $exosArray =[];
        foreach($exos as $exo){

        if($userParam->getTrainingLevel() == "Debutant")
        {
            $exoParam = [
                'series' => 2,
                'reps' => 8,
                'repos' => 3
            ];
        }
        elseif($userParam->getTrainingLevel() =="Intermediaire")
        {
            $exoParam = [
                'series' => 3,
                'reps' => 10,
                'repos' => 2
            ];
        }
        else{
            $exoParam = [
                'series' => 4,
                'reps' => 12,
                'repos' => 1
            ];
        }
        $exo = array_merge($exo->getArray(),$exoParam);
        $exosArray[] = $exo;
        
    }
    


       return $this->render('account/training.html.twig',[
           'user' => $this->getUser(),
           'exos' => $exosArray,
           'jours' => (int)$userParam->getTrainingFrequency()
       ]);
    }



 /**
     * Affiche page partage
     * 
     * @Route("/social/zone_publique", name="zone_publique")
     *
     * @return Response
     */
    public function partage()
    {
        return $this->render('social/zone_publique.html.twig');
    }


}
