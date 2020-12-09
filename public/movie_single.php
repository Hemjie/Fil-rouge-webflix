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



    if(isset($_GET['status']) && $_GET['status'] === 'success') {
        echo '<div class="container alert alert-success"> Le film a bien été ajouté</div>';
    }

    $duration = getMovie($id_movie)["duration"];
    $released = getMovie($id_movie)["released_at"];
?>

<div class="container my-4">
    <div class="row">
        <div class="col-lg-6">
            <img class="img-fluid" src="assets/img/<?= getMovie($id_movie)["cover"];?>" alt="<?= getMovie($id_movie)["title"];?>">
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="card-title"><?= getMovie($id_movie)["title"];?></h1>
                    <p class="medium-text">Catégorie : <?= getCategoryForOneMovie($id_movie)['name']?></p>
                    <p>Durée: <?= hour($duration); ?></p>
                    <p>Sorti le : <?= formatedDate($released);?></p>

                    <div>
                        <?= getMovie($id_movie)["description"];?> 
                    </div>     

                    <?php //Affichage des acteurs
                    /* On va essayer d'afficher les acteurs du film dans un ul*/
                        $actors = getActorsFromMovie($id_movie);
                    ?>
                    <div class="mt-5">
                        <h5>Avec:</h5>

                        <ul class="list-unstyled text-primary">
                            <?php foreach ($actors as $actor) {
                                $fullName = $actor['firstname']." ".$actor['name']; ?>
                                <li>
                                    <?= $fullName; ?>
                                    <a href="https://fr.wikipedia.org/wiki/<?= $fullName; ?>" target="_blank">(Wikipédia)</a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>                 
                </div>
                <div class="card-footer text-muted">
                    <?php                     
                    //boucle pour afficher les étoiles
                    for ($i = 1; $i <= 5; $i++) {
                        echo ($i <= getAverage($id_movie)) ? '★' : '☆';
                    }

                    echo ' '.getAverage($id_movie).'/5'; 
                    ?>
                </div>
            </div>

            <div class="card mt-5 shadow">
                <div class="card-body">
                    <?php
                        // récupérer les commentaires
                        $comments = getCommentsByMovie(getMovie($id_movie)['id']);
                        foreach ($comments as $comment) { ?>
                            <div class="mb-3">
                                <P class="mb-0">
                                    <strong><?= $comment['nickname']; ?></strong>
                                    <span class="small-text">Le <?= formatedDate($comment['created_at'], 'd/m/Y à H\hi'); ?></span>
                                </P>
                                <p>
                                    <?= $comment['message']; ?>
                                    <?= $comment['note']; ?>/5
                                </p>
                            </div>
                            <hr />
                        <?php } ?>                 

                    <?php
                        //Traitement du formulaire
                        if (!empty($_POST)) {
                            $nickname = htmlspecialchars($_POST['nickname']); //transform <script> en &gt;script&lt
                            $message = strip_tags($_POST['message']); //supprime <script> de la chaîne
                            $note = $_POST['note'];
                            $errors = [];

                            //On vérifie la validité des champs
                            if (empty($nickname)) {
                                $errors['nickname'] = "Le pseudo est vide";
                            }

                            if (strlen($message) < 15) {
                                $errors['message'] = "Le message est trop court";
                            }

                            if ($note < 0 || $note > 5) {
                                $errors['note'] = "La note n'est pas correcte";
                            }

                            // on fait la requête s'il n'y a pas d'erreurs
                            if (empty($errors)) {
                                $query = $db->prepare(
                                    'INSERT INTO `comment` (`nickname`, `message`, `note`, `created_at`, `movie_id`)
                                    VALUES (:nickname, :message, :note, NOW(), :movie_id)'
                                );
                                $query->bindValue(':nickname', $nickname);
                                $query->bindValue(':message', $message);
                                $query->bindValue(':note', $note, PDO::PARAM_INT);
                                $query->bindValue(':movie_id', getMovie($id_movie)['id'], PDO::PARAM_INT);
                                $query->execute();

                                // on redirige pour éviter que l'user ne renvoie le formulaire
                                //header('Location: movie_single.php?id='.getMovie($id_movie)['id']);
                                //si problème avec le header
                                echo '<meta http-equiv="refresh" content="0;URL="movie_single.php?id="'.getMovie($id_movie)['id'];

                            } else { 
                                echo "<div class='container alert alert-danger'>";
                                foreach($errors as $error) {
                                    echo "<p class='text-danger m-0'>".$error."</p>";
                                }
                                echo "</div>";
                            }
                        }
                    ?>

                    <form method="POST">
                        <label for="nickname">Pseudo</label>
                        <input type="text" name="nickname" id="nickname" class="form-control"><br />
                        <label for="message">message</label>
                        <textarea name="message" id="message" rows="3" class="form-control"></textarea><br />
                        <label for="note">Note</label>
                        <select name="note" id="note" class="form-control">
                            <?php 
                                for($i = 0; $i <= 5; $i++) { ?>
                                    <option value="<?= $i; ?>"><?= $i; ?>/5</option>
                            <?php  } ?>
                        </select><br />
                        <button class="btn btn-block btn-danger">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>



<?php
    require '../partials/footer.php';
?>
