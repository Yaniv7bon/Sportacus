<?php

namespace App\Controller;

use App\Entity\Exercices;
use App\Form\ExcerciceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExcerciceController extends AbstractController
{
    /**
     * Permet d'ajouter un excercice à la BDD
     * 
     * @Route("/exo/add", name="exo_add")
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
                "L'exercice a bien été ajouté à la BDD !"
            );
        }

        return $this->render('excercice/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
