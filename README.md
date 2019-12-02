# sym44lts
### Long term support (LTS) symfony 4.4.*
### Installation
Chargez l'exécutable pour windows à cette adresse: https://symfony.com/download

Installation de la version LTS de symfony 4, valable au moins 3 ans:

https://symfony.com/releases

Avec la commande:

    symfony new sym44lts --full --version=lts

### Démarrer le serveur en ligne de commandes sous windows:

    symfony server:start
    
ctrl + c permet de quitter le serveur

Si un [WARNING] vous déclare que le certificat ssl n'est pas installé, vous pouvez utiliser cette commande:

    symfony server:ca:install    
Vous pourrez alors, après redémmarage du serveur, utiliser https:
https://127.0.0.1:8000

### Vérifier que tout est à jour:

    composer update
On voit qu'on a pas de vérification de sécurité des dépendances, on va l'installer
#### security-checker
Cette bibliothèque regarde votre configuration, intérroge des bases de données pour vérifier que vos dépendances sont sécurisées:

    composer require security-check 
    
Elle est appelée à chaque composer update, ou on l'utilise comme ceci:

    php bin/console security:check    
### Utiliser Apache pour faire tourner Symfony
Si on fait un lien vers /public et que l'on souhaite rester en mode débuggage (que la toolbar reste active), on peut installer une bibliothèque pour ça:

    composer require symfony/apache-pack
  
  Elle fonctionnera en local comme sur nimporte quel serveur web. 
  
### Créons notre contrôleur général

    php bin/console make:controller
### création des templates
On utilise bootstrap 4, ici grâce aux CDN (Les fichiers sont en ligne)     

dans base.html.twig on rajoute le meta pour le responsive de bootstrap

    <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>{% block title %}Welcome!{% endblock %}</title>

On crée les blocks complémentaires dans bootstrap4.html.twig qui hérite de base.html.twig

/templates/home/index.twig hérite de bootstrap4.html.twig
### Chemins depuis un template
En interne, on utilise la fonction twig path() pour chercher dans Symfony le nom (ancre) du chemin voulu

pour l'accueil dans bootstrap4.html.twig:

    <a href="{{path('homepage')}}">Home</a>   
##### Astuce, pour trouver tous vos chemin depuis la console

    php bin/console debug:router
          
#### On change notre HomeController
pour tester le menu dans home/index.html.twig

    // création d'un tableau pour l'envoyer à twig
            $menu = ["Actualités"=>"/rubrique/actualites",
                    "Qui sommes-nous"=>"/rubrique/whois",
                    "Nous contacter"=>"/rubrique/contact",
                ];
            return $this->render('home/index.html.twig', [
                // envoi du tableau à twig sous le nom "suitemenu"
                "suitemenu"=>$menu,
            ]);    
#### Puis dans index.html.twig      
    {% block menuhaut %}
        {% for clef, valeur in suitemenu %}
        <li class="nav-item">
            <a class="nav-link" href="{{ valeur }}">{{ clef }}</a>
        </li>
        {% endfor %}
    {% endblock %}
    
#### on affiche sous forme de réponse http le titre

    ....
    use Symfony\Component\HttpFoundation\Response;
    ....
    /**
     * @Route("/rubrique/{titre}", name="rubriques")
     */
    public function showRubrique(string $titre){
        return new Response($titre);
    }
#### on modifie bles liens dans index.html.twig

     {% for clef, valeur in suitemenu %}
        <li class="nav-item">
            <a class="nav-link" href="{{ path('rubriques',{titre: valeur} ) }}">{{ clef }}</a>
        </li>
        {% endfor %}           
### Création de la DB
création du dossier datas dans lequel on met un fichier créé avec workbench (sym44lts.mwb)

#### Création d'un utilisateur 
dans PhpMyAdmin on crée un utilisateur nommé "sym44lts" avec comme mot de passe : "44lts", on coche :
 
 "Créer une base portant son nom et donner à cet utilisateur tous les privilèges sur cette base."
 
 #### création de .env.local
 On duplique .env sous le nom .env.local, ce fichier n'ira pas sur github, c'est généralement plus sécure, sauf quand on l'écrit manuellement dans readme.md ;-)
 
    DATABASE_URL=mysql://sym44lts:44lts@127.0.0.1:3306/sym44lts?serverVersion=5.7
  
  #### Importation de la DB vers notre dossier src/Entity 
  
    php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity
     
 Les fichiers sont créés dans src/Entity
    
#### Ajoutons les getters et setters
Et autres méthodes avec la commande:

    php bin/console make:entity --regenerate App
                  
#### Pour vérifier à tout moment si vos bibliothèques sont sécurisées
                      
    php bin/console security:check    
    
#### Création de fausses données
On charge les Fixtures

    composer require orm-fixtures --dev
Pour remplir nos tables avec des Fixtures, on va générer des fichiers pour le faire   

    php bin/console make:fixtures     
    
#### Dans la page de UserFixture
Insertion d'un utilisateur
    <?php
    
    namespace App\DataFixtures;
    
    use App\Entity\User;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;
    
    class UserFixtures extends Fixture
    {
        public function load(ObjectManager $manager)
        {
            // création d'une instance de Entity/User
            $user = new User();
    
            // utilisation des setters pour remplir l'instance
            $user->setThelogin("Lulu")
                ->setThename("Lulu Poilu")
                ->setThepwd("Lulu");
    
            // on sauvegarde l'utilisateur dans doctrine
            $manager->persist($user);
    
            // doctrine enregistre l'utilisateur dans la table user
            $manager->flush();
        }
    }
On va charger cette fixture vers la DB:

    php bin/console doctrine:fixtures:load
    
! ça vide la base de donnée     

#### Boucle pour en insérer plusieurs
La boucle for nous permet d'en insérer plusieurs, on utilise $i pour éviter le DUPLICATE CONTENT

    public function load(ObjectManager $manager)
        {
            // création d'une instance de Entity/User
            $user = new User();
    
            // Autant d'utilisateurs que l'on souhaite
            for($i=0;$i<50;$i++) {
    
                // utilisation des setters pour remplir l'instance
                $user->setThelogin("Lulu$i")
                    ->setThename("Lulu Poilu$i")
                    ->setThepwd("Lulu$i");
    
                // on sauvegarde l'utilisateur dans doctrine
                $manager->persist($user);
            }
            // doctrine enregistre l'utilisateur dans la table user
            $manager->flush();
        }
Le $manager->persist reste dans la boucle.

Le $manager->flush() effectue réellement la requête (un seul insert de 50 lignes)                    