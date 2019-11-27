<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        // création d'un tableau pour l'envoyer à twig
        $menu = ["Actualités"=>"/rubrique/actualites",
                "Qui sommes-nous"=>"/rubrique/whois",
                "Nous contacter"=>"/rubrique/contact",
            ];
        return $this->render('home/index.html.twig', [
            // envoi du tableau à twig sous le nom "suitemenu"
            "suitemenu"=>$menu,
        ]);
    }
}
