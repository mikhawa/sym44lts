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