# POKEGAME (webtp6)

### Technologies supplémentaires

IDE : Phpstorm

Bootstrap pour le front avec le logiciel Bootstrap Studio

### Misc.

Bug sur le temps de repos, la vérification est bonne mais le temps sur le serveur change d'une requête à l'autre.

L' "elo" qu'on retrouve sur les deux classes "User" et "Pokemons" devait servir à une fonctionnalité de combat que nous avons pas eu le temps de mettre en place.

Diagramme de notre BDD :

![bbd](https://i.ibb.co/dcy6p7V/Untitled-Diagram.png)

### Premier lancement

Vous devez lancer les instructions suivantes dans l'ordre avant le premier lancement.

1. Créer un utilisateur webtp6, son mdp sera : "webtp6"
2. Créer la base associée et donnez lui tous les privilèges.
3. Dans la console de phpstorm tapez ces trois lignes de commandes:

⋅⋅* Préparer la migration
```
php bin/console make:migration
```
⋅⋅* Migrer
```
php bin/console doctrine:migrations:migrate
```
⋅⋅* Peupler la base de donnée.
```
php bin/console doctrine:fixtures:load
```

### Fonctionalités disponibles

#### Pokédex

Retrouve les nombres importants des pokémons que tu détiens, nb total, nb de Pokémon de type Feu, etc.

#### Mes Pokémons

Liste de tous les pokémons que tu possèdes, tu peux les inspecter en cliquant sur leur nom (de l'inspection tu pourras les libérer).
Aussi tu peux les vendre rapidement.

#### Marché

Tu retrouves ici les pokémons misent en vente, les pokémons que tu peux mettre en vente.

#### Entraînement

Ici t'entraîne tes pokémons pour qu'ils gagnent entre 10 et 30xp, attention 1h de repos entre chaque entraînement et chasse. (on y vient)

#### Chasse

Pars chasser avec tes pokémons dans les différentes régions proposés, chacune propose ses types de pokémon favoris. Là aussi tes pokémons se fatiguent mais gagnent de l'expérience.
Le taux de capture d'un pokémon a trois variables : L'xp du pokémon, si c'est une évolution et si le pokémon en face est une évolution.

La formule est la suivante : Où A est ton pokémon et B le pokemon que tu captures
![equation](http://www.sciweavers.org/upload/Tex2Img_1592487991/render.png)

