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
        $sort = $_GET['sort'] ?? 'id';
        if(!in_array($sort, ["id", "title", "duration", "released_at"])) {
            // Si $sort vaut autre chose que les 4 valeurs du tableau, on le force à la valeur id
            $sort = "id";
        }
        //requête préparée pour éviter injections SQL
        $query = $db->prepare('SELECT * FROM `movie` WHERE `title` LIKE :q ORDER BY '.$sort);
        $query->bindValue(':q', '%'.$q.'%');
        $query->execute();

        //autre méthode pour faire bindvalue et execute en une ligne
        // $query->execute([':q' => '%'.$q.'%']);

        return $query->fetchAll();
    }

    //fonction qui renvoie la 404
    function display404() {
        http_response_code(404); //on peut forcer le statut sur la requête
        echo "<div class='container'><h1>404</h1></div>";
        require '../partials/footer.php'; exit();
    }

    // fonction qui affiche par catégories

    function getMoviesByCategories($id_cat) {
        global $db;
        $query = $db->prepare('SELECT * FROM `movie` WHERE category_id = :id_cat');
        $query->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll();
    }

    function getCategory($id_cat) {
        global $db;
        $query = $db->prepare('SELECT * FROM `category` WHERE id = :id_cat');
        $query->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(); 
    }

    function getMovie($id_movie) {
        global $db;
        $query = $db->prepare('SELECT * FROM `movie` WHERE id = :id_movie');
        $query->bindValue(':id_movie', $id_movie, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(); 
    }
?>
