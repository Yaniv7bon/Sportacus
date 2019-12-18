<?php

namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * Affiche la liste des utilisateurs
     * 
     * @Route("/admin/users", name="admin_users")
     * @IsGranted("ROLE_ADMIN")
     */
    public function userIndex(UserRepository $repo)
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $repo->findAll()
        ]);
    }
   





}



