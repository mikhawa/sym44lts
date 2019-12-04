<?php

namespace App\DataFixtures;


use App\Entity\Categ;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CategFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create("fr_BE");

        // nombre de catégories
        $_SESSION['nb_categ']=8;

        // on récupère le nombre d'articles
        $nb_article = $_SESSION['nb_article'];

        for($i=0;$i<$_SESSION['nb_categ'];$i++) {

            $categ = new Categ();

            $this->addReference("mes_categs_".$i,$categ);



            // setters de la table categ
            $categ->setTitre($fake->sentence(10,true))
            ->setSlug($fake->slug(8,true))
            ->setDescr($fake->sentence(45,true));

            $categ->addArticleIdarticle();


            $manager->persist($categ);
        }

        $manager->flush();
    }

    /**
     * Dépendances pour le manyTomany (addArticleIdarticle), on doit déjà avoir des articles pour faire le lien dans categ_has_article
     */
    public function getDependencies()
    {
        return array(
            ArticleFixtures::class,
        );
    }
}
