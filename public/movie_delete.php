<?php

    ob_start();
    require "../partials/header.php";

    if (!isAdmin()) {        
        display403();
    } 

    if (isset($_GET['id'])) {
        $id_movie = $_GET['id'];
    } else {
        display404();
    }

    //attention à la faille CSRF
    /*
    * Pour se protéger de cette faille, il faut générer un token (code aléatoire) qu'on stocke dans la session
    * Pour supprimer un film, on ajoutera le token dans l'url et on vérifiera que ce token correspond à celui de la session
    */

    if (!isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
        display404();
    }

    //requête pour supprimer le film
    $query = $db->prepare('DELETE FROM `movie` WHERE `id` = :id_movie');
    $query->bindValue(':id_movie', $id_movie, PDO::PARAM_INT);
    $query->execute();

    header('Location: movie_list.php');

?>

