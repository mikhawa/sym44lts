<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// nécessaire pour la requête du menu
use App\Entity\Categ;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        // Doctrine récupère tous les champs de la table Categ
        $recupMenu = $this->getDoctrine()->getRepository(Categ::class)->findAll();

        //dump($recupMenu);

        // chargement du template
        return $this->render('home/index.html.twig', [
            // envoi du résultat de la requête à twig sous le nom "suitemenu"
            "suitemenu"=>$recupMenu,
        ]);
    }
    /**
 * @Route("/categ/{slug}", name="categ")
 */
    public function detailCateg($slug){
        return new Response($slug);
    }

}
