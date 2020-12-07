<?php
    require '../partials/header.php';

    /*
    * Cette page sera comme movie_list sauf que:
    * 1. on doit récupérer l'id de la catégorie dans l'URL
    * 2. faire la requête pour récupérer les films de cette catégorie
    * si on veut, on peut faire le filtre
    */

    if (isset($_GET['id'])) {
        $id_cat = $_GET['id'];
    } else {
        display404();
    }

    if (!getCategory($id_cat)) {
        display404();
    }
?>

<div class="container">
    <h1 class="my-4"><?= getCategory($id_cat)['name']; ?></h1>
    <div class="row mb-5">        
        <?php foreach(getMoviesByCategories($id_cat) as $movie) {
            require "../partials/card-movie.php";
        } ?>
    </div>
</div>

<?php
    require '../partials/footer.php';
?>
