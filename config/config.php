<?php
    /*
     | ----------------------------------
     |      Fichier de configuration
     | ----------------------------------
     |
     | Ce fichier contient toutes les variables globales pour le site
     | Titre du site, information de connexion à la BDD
     |
    */

    // nom du fichier de la page active basename(URL actuelle)
    $pageActive = basename($_SERVER["PHP_SELF"]);

    //on démarre la session
    session_start();

    //on va générer un token pour le CSRF
    if (!isset($_SESSION['token'])) {        
        $_SESSION['token'] = md5(uniqid());
    }
?>
