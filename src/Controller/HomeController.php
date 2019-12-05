<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// nécessaire pour la requête du menu
use App\Entity\Categ;
// nécessaire pour les articles
use App\Entity\Article;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        // Doctrine récupère tous les champs de la table Categ
        $recupMenu = $this->getDoctrine()->getRepository(Categ::class)->findAll();

        // Doctrine récupère les 10 derniers articles
        $recupArticles = $this->getDoctrine()->getRepository(Article::class)->findBy([],["thedate"=>"DESC"],10);

        //dump($recupMenu);

        // chargement du template
        return $this->render('home/index.html.twig', [
            // envoi du résultat de la requête à twig sous le nom "suitemenu"
            "suitemenu"=>$recupMenu,
            "articles"=>$recupArticles,
        ]);
    }
    /**
    * @Route("/categ/{slug}", name="categ")
    */
    public function detailCateg($slug){
        return new Response($slug);
    }

}
