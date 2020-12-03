<?php require "../partials/header.php" 

?>

<div class="container">

    <?php
        /*
        * 1. Poser le dropdown comme sur la maquette
        * 2. Définir un lien comme movie_list.php?sort=released_at
        * 3. Récupérer le paramètre sort de l'URL ($_GET)
        * 4. Grâce à ce paramètre, modifier la requête SQL
        */
    ?>
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

    <?php
        $sort= 'id';
        if (isset($_GET["sort"]) && !empty($_GET["sort"])) {
            $sort = $_GET['sort'];
        }
    ?>

    <div class="row">        
        <?php foreach(getListMovies($sort) as $movie) {
            require "../partials/card-movie.php";
        } ?>
    </div>
</div>

<?php require "../partials/footer.php" ?>
