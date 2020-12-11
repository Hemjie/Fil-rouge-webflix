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

    //requête pour supprimer le film
    $query = $db->prepare('DELETE FROM `movie` WHERE `id` = :id_movie');
    $query->bindValue(':id_movie', $id_movie, PDO::PARAM_INT);
    $query->execute();

    header('Location: movie_list.php');

?>

