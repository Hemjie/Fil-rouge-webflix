<?php
    /*
     | ----------------------------------
     |   Connexion à la base de données
     | ----------------------------------
     |
     | Permet d'établir la connexion entre PHP et MySQL
     |
    */

    // On va pouvoir se connecter avec PDO
    try {
        $db = new PDO("mysql:host=localhost;port=3306;dbname=webflix", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //On active les erreurs SQL
        ]);
    } catch (Exception $e) {
        echo "<img width='100' src='assets/img/travolta.gif'>"; //on peut personnaliser le msg d'erreur
        echo $e ->getMessage(); // Affiche le msg d'erreur
        exit();                 // Arrête le code
    }
?>