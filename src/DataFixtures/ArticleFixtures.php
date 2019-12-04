<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
// pour charger d'abord UserFixtures.php
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
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
            $slug = $fake->slug;
            $text = $fake->text(500);
            $date = $fake->dateTime();

            $a = random_int(0,$_SESSION['nbUser']-1);
            $iduser = $this->getReference("user_reference_" . $a);


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
    // les utilisateurs sont chargés en premier
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
