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

<div class="container my-4">
    <div class="row">
        <div class="col-lg-6">
            <img class="img-fluid" src="assets/img/<?= getMovie($id_movie)["cover"];?>" alt="<?= getMovie($id_movie)["title"];?>">
        </div>
        
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

            <div class="card mt-5 shadow">
                <div class="card-body">
                    <?php
                        //Traitement du formulaire
                        if (!empty($_POST)) {
                            $nickname = $_POST['nickname'];
                            $message = $_POST['message'];
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
                                header('Location: movie_single.php?id='.getMovie($id_movie)['id']);

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
