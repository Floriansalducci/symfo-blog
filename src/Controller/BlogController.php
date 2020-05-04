<?php

namespace App\Controller;


use App\Entity\Comment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Articls;
use App\Repository\ArticlsRepository;
use App\Form\ArticlsType;
use App\Form\CommentType;



class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticlsRepository $repo,ObjectManager $manager)
    {
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=> $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */

    public function home()
    {
        return $this->render('blog/home.html.twig');
    }



    /**
    * @Route("/blog/new", name="blog_create")
     * * @Route("/blog/{id}/edit", name="blog_edit")
    */

    //Création et de modification du formulaire + Create twig
    public function form(Articls $article = null,Request $request, ObjectManager $manager)
    {
        if(!$article){
            $article = new Articls();
        }

        //Générer le form de maniere classique
        //$form = $this->createFormBuilder($article)
              //  ->add('title',)
              //  ->add('content', )
              //  ->add('image')
              //  ->getForm();

        //Permet de récuperer le form crée directement dans la console (php bin/console make:form)
       $form = $this->createForm(ArticlsType::class, $article);

        //Soumission du formulaire
        $form->handleRequest($request);
        //Permet de modifier le formulaire si il est deja crée
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId())
            $article->setCreatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' =>$article->getId()]);
        }
        dump($article);
        $entityManager = $this->getDoctrine()->getManager();


        return $this -> render('blog/create.html.twig' , 
        [
          'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */


    public function show(Articls $articls, Request $request, ObjectManager $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setArtilcs($articls);
            //Valide le commentaire
            $manager->persist($comment);
            // L'envoi dans la bdd
            $manager->flush();

            return $this->redirectToRoute('blog_show', [
                'id'=> $articls->getId()
            ]);
        }

        return $this->render('blog/show.html.twig', [
            'articls'=> $articls,
            'commentForm'=>$form->createView()
            ]
            );
    }
}
   