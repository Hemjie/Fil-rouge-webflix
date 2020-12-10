# Webflix PHP SQL

On va créer un clone de Netflix afin d'apprendre à créer un projet en PHP / SQL.
![fil-rouge-webflix](/maquettes/maquette-accueil-webflix.png)

## Fonctionalités attendues

Le client nous a donné une liste de maquettes, ce qui va nous permettre de déduire les fonctionnalités à développer sur le site. Etant donné que nous sommes stagiaire dans l'entreprise, notre tuteur nous a également donné quelques informations pour la réalisation technique.

Optionnellement, on pourra réaliser un back office pour que l'administrateur puisse gérer les films.

## Partie Back

- x`config/database.php` : Contiendra la connexion à la BDD. A inclure dans tous les fichiers.
- `config/config.php` : Contiendra les variables de configuration du projet.
- x`config/functions.php` : Contiendra des fonctions utiles pour le projet.
- x`partials/header.php` : Le header du site à inclure sur toutes les pages.
- x`partials/footer.php` : Le footer du site à inclure sur toutes les pages.

## Partie Front

- x`public/assets` : Dossier qui contient le CSS, le JS et les images.
- x`public/assets/css`
- x`public/assets/js`
- x`public/assets/img`
- x`public/assets/uploads` : Dossier qui contient les images uploadées (Films, avatars).

## Les pages

- x`public/index.php` : Page d'accueil du site qui affiche 4 films aléatoires de la BDD ainsi qu'un carousel.
- x`public/movie_list.php` : Lister tous les films de la BDD. On peut filter les films par durée, nom etc.
- x`public/movie_search.php` : Système de recherche
- x`public/category_single` : Voir les films d'une catégorie
- x`public/movie_single.php` : La page d'un seul film.
- x`public/movie_add.php` : Permet d'ajouter un film. On doit vérifier que l'utilisateur soit connecté.
- `public/movie_update.php` : Permet de modifier un film. On doit vérifier que l'utilisateur soit connecté.
- `public/movie_delete.php` : Permet de supprimer un film. On doit vérifier que l'utilisateur soit connecté.
- x`public/actor_single.php` : La page d'un acteur avec ses films.
- x`public/register.php` : Page d'inscription.
- x`public/login.php` : Page de connexion.
- `public/account.php` : Page du compte utilisateur. Lui permet de modifier ses informations.

## Options

- `public/movie_api.php` : Permet de rendre disponible nos films sur une api pour une appli mobile par exemple.

## Base de données

Voici les tables à créer :

- movie
    - id
    - title
    - released_at
    - description
    - duration
    - cover
    - category_id

- comment
    - id (obligatoire)
    - nickname (obligatoire) varchar
    - message (obligatoire) txt
    - note (obligatoire) int
    - created_at (obligatoire) date et heure
    - movie_id (obligatoire) auto

- category
    - id
    - name

- actor
    - id
    - name
    - firstname
    - birthday

- movie_has_actor
    - movie_id
    - actor_id

- user
    - id
    - email (obligatoire) varchar
    - username (obligatoire) varchar
    - password (obligatoire) varchar
    - token varchar
    - requested_at date et heure

- payment
    - id
    - stripe_id (obligatoire) varchar
    - status (obligatoire) varchar
    - amount (obligatoire) int
    - user_id (obligatoire)
    - movie_id (obligatoire)
