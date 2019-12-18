<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use App\Entity\Post;
use App\Form\PostType;


class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     * @Route("/social/zone_publique", name="zone_publique")
     */
    public function comment(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post, [
            'action' => $this->generateUrl('form'),
            // 'method' => 'GET'
        ]);

        //Gestion de la requete

        $form->handleRequest($request);    

// enregistrement dans la BDD
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($post);
            $manager->flush();

            // pour "effacer" les donnes du commentaire apres validation
            return $this->redirectToRoute('zone_publique');
        }

        


        return $this->render('form/index.html.twig', [
            'post_form' => $form->createView()
        ]);
    }
}
