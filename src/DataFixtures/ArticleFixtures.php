<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\ORM\EntityManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // chargement de Faker
        $fake = Factory::create("fr_BE");

        // Autant d'articles que l'on souhaite
        for($i=0;$i<100;$i++) {

            // création d'une instance de Entity/User
            $article = new Article();

            // création des variables via Faker
            // phrase de 1 à 8 mots
            $titre = $fake->sentence(8, true);
            // slug

            /*
             *
             * C'est de la merde
             *
             *
             */

            $slug = $fake->slug;
            $text = $fake->text(500);
            $date = $fake->dateTime();
            $em = EntityManager::class->getDoctrine()->getRepository(User::class);
            $query = $em->find(random_int(56,103));
            $iduser = $query->getIduser();

            // utilisation des setters pour remplir l'instance
            $article->setTitre($titre)
                ->setSlug($slug)
                ->setTexte($text)
                ->setThedate($date)
                ->setUserIduser($iduser);

            // on sauvegarde l'article dans doctrine
            $manager->persist($article);
        }
        // doctrine enregistre les articles dans la table article
        $manager->flush();
    }
}
