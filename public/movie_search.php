<?php
/*
* 1. dans ce fichier, on va afficher les films par rapport à la recherche
* 2. on doit récupérer le paramètre q (pour query dans l'url)
* 3. si le paramètre n'est pas présent soit on affiche une 404, un msg ou on redirige vers les films
* 4. si le paramètre est présent, il faut faire la bonne requête SQL (LIKE)
* 5. On affiche le résultat (les films) comme sur les autres pages
* 6. Et s'il n'y a pas de films? on affiche "La recherche n'a rien donné"
*/ 

    require '../partials/header.php';

    /* if (isset($_GET["q"])) {
        $q = $_GET["q"];
    } else {
        echo "<div class='container'><h1>404</h1></div>";
    } */

    // nouvel opérateur en PHP : Null coalesce
    $q = $_GET["q"] ?? null; //si $_GET["q"] est isset, $q vaut $_GET["q"] sinon $q vaut null
    if ($q === null) {
        echo "<div class='container'><h1>404</h1></div>"; 
        require '../partials/footer.php'; exit();
    }
    ?>

    <div class="container">
        <div class="dropdown my-4">
            <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="movie_list.php?sort=id">Par défaut</a>
                <a class="dropdown-item" href="movie_list.php?sort=title">Nom</a>
                <a class="dropdown-item" href="movie_list.php?sort=duration">Durée</a>
                <a class="dropdown-item" href="movie_list.php?sort=released_at">Date de sortie</a>
            </div>
        </div>
        <div class="row">
            <?php 
            if (empty(getSearchMovies($q))) {
                echo "<h1 class='mb-4'>La recherche ne donne aucun résultat</h1>";
            }

            foreach(getSearchMovies($q) as $movie) {
            require '../partials/card-movie.php';
            } ?>
        </div>
    </div>

<?php
    require '../partials/footer.php';
?>
