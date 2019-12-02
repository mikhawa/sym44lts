<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getRepository(User::class);
        $query = $em->find(random_int(56,103));
        //shuffle($query);
        dump($query);
        // création d'un tableau pour l'envoyer à twig
        $menu = ["Actualités"=>"actualites",
                "Qui sommes-nous"=>"whois",
                "Nous contacter"=>"contact",
            ];
        // chargement du template
        return $this->render('home/index.html.twig', [
            // envoi du tableau à twig sous le nom "suitemenu"
            "suitemenu"=>$menu,
        ]);
    }

}
