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

    $duration = getMovie($id_movie)["duration"];
    $released = getMovie($id_movie)["released_at"];
?>

<div class="container mx-auto my-4 row">
    <img class="col-lg-6" src="assets/img/<?= getMovie($id_movie)["cover"];?>" alt="<?= getMovie($id_movie)["title"];?>">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title"><?= getMovie($id_movie)["title"];?> - <?= getCategoryForOneMovie($id_movie)['name']?></h5>
                <p>Durée: <?= hour($duration); ?></p>
                <p>Sorti le : <?= formatedDate($released);?></p>

                <div>
                <?= getMovie($id_movie)["description"];?> 
                </div>                      
            </div>
            <div class="card-footer">
                <small class="text-muted">★★★★☆</small>
            </div>
        </div>
    </div>
</div>

<?php
    require '../partials/footer.php';
?>
