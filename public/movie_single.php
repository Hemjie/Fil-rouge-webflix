<?php
    require '../partials/header.php';

    /*
    * Récupérer les informations du film
    1. sur chaque lien "Voir le film", on doit ajouter un lien vers movie_single.php?id=5
    2. on va récupérer l'id dans l'url
    3. on doit vérifier si id présent ou non (404)
    4. on doit récupérer le film dans la BDD avec id (404)
    5. on affiche les infos du films(jacquette,titre,durée, date, description...)
    6. on va aussi ajouter la catégorie
    */

    if (isset($_GET['id'])) {
        $id_movie = $_GET['id'];
    } else {
        display404();
    }

    if (!getMovie($id_movie)) {
        display404();
    } 
?>

<div class="container">
    <img src="assets/img/<?= getMovie($id_movie)["cover"];?>" alt="<?= getMovie($id_movie)["title"];?>">
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title"><?= getMovie($id_movie)["title"];?></h5>
            <p>Durée: <?= getMovie($id_movie)["duration"]?> minutes</p>
            <p><strong>Sorti le : <?= getMovie($id_movie)["released_at"];?></strong></p>
            <p class="card-text"><?= getMovie($id_movie)["description"];?></p>            
        </div>
        <div class="card-footer">
            <small class="text-muted">★★★★☆</small>
        </div>
    </div>
</div>

<?php
    require '../partials/footer.php';
?>
