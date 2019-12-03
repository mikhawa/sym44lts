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

        // Autant d'utilisateurs que l'on souhaite
        for($i=0;$i<50;$i++) {

            // création d'une instance de Entity/User
            $user = new User();
            $this->addReference("user_reference_".$i, $user);


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
