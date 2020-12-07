<?php
    require '../partials/header.php';

    /*
    * Cette page sera comme movie_list sauf que:
    * 1. on doit récupérer l'id de la catégorie dans l'URL
    * 2. faire la requête pour récupérer les films de cette catégorie
    * Ne pas afficher les filtres de tri
    */

    if (isset($_GET['id'])) {
        $id_cat = $_GET['id'];
    } else {
        display404();
    }
?>

<div class="container">
    <div class="row mb-5">        
        <?php foreach(getMoviesByCategories($id_cat) as $movie) {
            require "../partials/card-movie.php";
        } ?>
    </div>
</div>

<?php
    require '../partials/footer.php';
?>