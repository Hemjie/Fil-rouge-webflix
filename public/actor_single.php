<?php
    require '../partials/header.php';

    /**
     * On va créer la page pour voir un acteur seul
     * 1. Ecrire une requête pour afficher le nom de l'acteur
     * 2. Ecrire une requête pour afficher les films de cet acteur
     * BONUS: Faire tout cela en une seule requête
     */

    if (isset($_GET['id'])) {
        $id_actor = $_GET['id'];
    } else {
        display404();
    }

    if (!getActor($id_actor)) {
        display404();
    }

    // $actor = getActor($id_actor);
    $infos = getInfosFromActor($id_actor);
    $fullName = $infos[0]['firstname'].' '.$infos[0]['name'];
    // $movies = getMoviesFromActor($id_actor);
    
?>

<div class="container">
    <h1 class="my-4">
        Les films de <?= $fullName ?>
    </h1>
    <div class="row mb-5">
        <?php foreach($infos as $movie) {
            require "../partials/card-movie.php";
        } ?>
    </div>
</div>

<?php
    require '../partials/footer.php';
?>