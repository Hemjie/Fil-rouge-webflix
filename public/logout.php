<?php
    //cette page permet de se déconnecter
    session_start();

    //on déconnecte l'utilisateur
    unset($_SESSION['user']);

    header('Location: index.php');
?>
