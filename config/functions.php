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

    function getCategories($category) {
        return '<a class="dropdown-item" href="#">'.$category["name"].'</a>';
        }
?>