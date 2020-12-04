<?php
    /*
     | ----------------------------------
     |   Fonctions utiles pour le site
     | ----------------------------------
     |
     | Ici, on va déclarer toutes les fonctions qui seront utilisables partout sur le site.
     |
    */

    //Fonction pour remplir le dropdown avec les catégories

    function getCategories() {
        global $db; // On utilise la variable $db, PDO
        $query = $db->query('SELECT * FROM `category` ORDER BY `name`');
        return $query->fetchAll();
    }

    // fonction pour récupérer 4 films aléatoires pour la page d'accueil
    function get4Movies() {
        global $db;
        $query = $db->query('SELECT * FROM `movie` ORDER BY RAND() LIMIT 4');
        return $query->fetchAll();
    }

    // fonction pour récupérer les 9 films les plus récent pour le carrousel
    function getCarousel() {
        global $db;
        $query = $db->query('SELECT * FROM `movie` WHERE `cover` IS NOT NULL ORDER BY `released_at` DESC LIMIT 9');
        return $query->fetchAll();
    }

    // fonction pour récupérer tous les films dans la BDD avec un tri
    function getListMovies($sort) {
        global $db;
        // attention introduire une variable php dans une requête sql entraîne une faille de sécurité (injection SQL)
        // on doit vérifier l'intégrité de la variable avant de faire la requête
        // idéalement, on utilisera une requête préparée

        if(!in_array($sort, ["id", "title", "duration", "released_at"])) {
            // Si $sort vaut autre chose que les 4 valeurs du tableau, on le force à la valeur id
            $sort = "id";
        }

        $query = $db->query('SELECT * FROM `movie` ORDER BY '.$sort.''); 
        return $query->fetchAll();
    }

    // fonction pour la recherche de films dans la BDD
    function getSearchMovies($q) {
        global $db;
        $query = $db->query('SELECT * FROM `movie` WHERE `title` LIKE "%'.$q.'%"');

        return $query->fetchAll();
    }
?>
