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

    function get4Movies() {
        global $db;
        $query = $db->query('SELECT * FROM `movie` ORDER BY RAND() LIMIT 4');
        return $query->fetchAll();
    }
?>