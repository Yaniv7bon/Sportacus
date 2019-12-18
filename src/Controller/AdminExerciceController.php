<?php

namespace App\Controller;

use App\Entity\Exercices;
use App\Form\ExcerciceType;
use App\Repository\ExercicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminExerciceController extends AbstractController
{
     /**
     * Affiche la liste des exercices
     * 
     * @Route("/admin/exos", name="admin_exos")
     * @IsGranted("ROLE_ADMIN")
     */
    public function exosIndex(ExercicesRepository $repo)
    {
        return $this->render('admin/exercices/index.html.twig', [
            'exos' => $repo->findAll()
        ]);
    }

    /**
     * Supprime un exercice
     * 
     * @Route("admin/exos/{id}/delete", name="admin_exo_delete")
     * 
     */
    public function delete(Exercices $exo,EntityManagerInterface $manager)
    {
        $manager->remove($exo);
        $manager->flush();

        $this->addFlash(
            "success",
            "L'exercice a bien été supprimé"
        );

        return $this->redirectToRoute("admin_exos");
    }

     /**
     * Permet d'ajouter un excercice à la BDD
     * 
     * @Route("admin/exos/add", name="admin_exo_add")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return Response
     */
    public function add(EntityManagerInterface $manager,Request $request)
    {
        $exo = new Exercices();
        $form = $this->createForm(ExcerciceType::class,$exo);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($exo);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'exercice a bien été ajouté à la base de donnée !"
            );

            return $this->redirectToRoute("admin_exos");
        }

        return $this->render('admin/exercices/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
