<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // chargement de Faker
        $fake = Factory::create("fr_BE");

        // création d'une variable de session contenant le nombre d'utilisateur que l'on souhaite créer
        $_SESSION['nb_users']=150;

        // Autant d'utilisateurs que l'on souhaite
        for($i=0;$i<$_SESSION['nb_users'];$i++) {

            // création d'une instance de Entity/User
            $user = new User();

            // on crée autant de références que d'utilisateurs que l'on souhaite créer, il seront utilisés dans ArticleFixtures.php
            $this->addReference("mes_users_".$i,$user);

            // création des variables via Faker
            $login = $fake->userName;
            $name = $fake->name;
            $pwd = $fake->password(12);

            // utilisation des setters pour remplir l'instance
            $user->setThelogin($login)
                ->setThename($name)
                ->setThepwd($pwd);

            // on sauvegarde l'utilisateur dans doctrine
            $manager->persist($user);
        }
        // doctrine enregistre l'utilisateur dans la table user
        $manager->flush();
    }
}
