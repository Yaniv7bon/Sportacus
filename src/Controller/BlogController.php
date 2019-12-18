<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
//use Doctrine\ORM\EntityManager;
use App\Controller\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Common\Persistence\ManagerRegistry;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_index")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();    


        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }


    /**
     * @Route("/blog/home", name="blog_home")
     */
public function home() {
    return $this->render('blog/home.html.twig', ['title' => "Bienvenue sur le blog Sportacus !"]);
}

/**
 * @Route("/blog/new", name="blog_create")
 * @Route("blog/{id}/edit", name="blog_edit")
 */
public function form(Article $article = null, Request $request, ObjectManager $manager) {

    if(!$article) {
        $article = new Article();
    }
    

    $form = $this->createFormBuilder($article)
                 ->add('title')
                 ->add('content')
                 ->add('image')
                 ->getForm();  

$form->handleRequest($request);

if($form->isSubmitted() && $form->isValid()) {

if(!$article->getId()){

    $article->setCreatedAt(new \DateTime());
}    

    $manager->persist($article);
    $manager->flush();

    return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);

}

    return $this->render('blog/create.html.twig', [
        'formArticle' => $form->createView(),
        'editMode' => $article->getId() !== null
    ]);
}



/**
 * @Route("/blog/{id}", name="blog_show")
 */
public function show($id){

    $repo = $this->getDoctrine()->getRepository(Article::class);

    $article = $repo->find($id);

    return $this->render('blog/show.html.twig', ['article' => $article]);

}





}
