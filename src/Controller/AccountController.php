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
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été crée ! Vous pouvez maintenant vous connectez !'
            );

            return $this->redirectToRoute("account_login");
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
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
     * Profil utilisateur
     * 
     * @Route("/account", name="account_index")
     *
     * @return Response
     */
    public function myAccount(EntityManagerInterface $manager,Request $request)
    {   
        $habits = new UserTraining();
        $form = $this->createForm(UserTrainingType::class, $habits);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $habits->setUser($this->getUser());

            $manager->persist($habits);
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
            $exoPram = [
                'series' => 4,
                'reps' => 12,
                'repos' => 1
            ];
        }
        $exo = array_merge($exo->getArray(),$exoParam);
        $exosArray[] = $exo;
        
    }
    dump($exosArray);


       return $this->render('account/training.html.twig',[
           'user' => $this->getUser(),
           'exos' => $exosArray,
           'jours' => (int)$userParam->getTrainingFrequency()
       ]);
    }
}
