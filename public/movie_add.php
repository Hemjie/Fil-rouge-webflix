<?php
    require "../partials/header.php";

    /**
     * Formulaire d'ajout de film
     * 
     * Ici, on va créer un formulaire permettant d'ajouter un film.
     * Le champ title devra faire 2 caractères minimum.
     * Le champ description devra faire 15 caractères minimum.
     * On pourra uploader une jaquette. Le nom du fichier uploadé doit être le nom du film "transformé", "Le Parrain" -> "le-parrain.jpg"
     * Le champ durée devra être un nombre entre 1 et 999.
     * Le champ released_at devra être une date valide.
     * Le champ category devra être un select généré dynamiquement avec les catégories de la BDD
     * On doit afficher les messages d'erreurs et s'il n'y a pas d'erreurs on ajoute le film et on redirige sur la page movie_list.php
     * BONUS : Il faudrait afficher un message de succès après la redirection. Il faudra utiliser soit la session, soit un paramètre dans l'URL
     */

     // Vérifier si user peut accéder à la page
    if (!isAdmin()) {
        display403();
    } 

    $title = $description = $cover = $duration = $released_at = $categorySelected = null;
    
    if (!empty($_POST)) {
        $errors = [];
        $title = htmlspecialchars($_POST['title']);
        $cover = $_FILES["cover"];
        $description = strip_tags($_POST['description']);        
        $duration = $_POST['duration'];
        $released_at = $_POST['released_at'];
        $categorySelected = $_POST['category'];

        // on fait l'upload ici           
        $arrayExtension = ['image/jpg', 'image/jpeg', 'image/png'];
        var_dump($cover);
        if ($cover["error"] === 0 && $cover["size"] < 10*1024*1024 && in_array($cover["type"], $arrayExtension)) {
            if (!is_dir("assets/img")) {                  
            mkdir("assets/img");
            }
            
            $extension = pathinfo($cover["name"])['extension'];
            $fileName = str_replace(' ', '-', strtolower($title)).".".$extension;

            move_uploaded_file($cover["tmp_name"], "assets/img/".$fileName);           
        } else {
            $errors["cover"] = "Le format et/ou la taille de l'image est incorrect";
        }         
                 
        if (strlen($title) < 2) {
             $errors['title'] = "Le titre du film doit contenir au moins 2 caractères";
         }

         if (strlen($description) < 15) {
            $errors['description'] = "Le description du film doit contenir au moins 15 caractères";
         }

         if ($duration < 1 || $duration > 999) {
             $errors['duration'] = "La durée du film doit être comprise entre 1 et 999";
         }
         
         $released_at = empty($released_at) ? '0000-00-00' : $released_at;
         $date = explode('-', $released_at);
         if (!checkdate($date[1], $date[2], $date[0]) || $date[0] < 1888 || $date[0] > date("Y")) {
            $errors['released_at'] = "Il y a une erreur sur l'année de sortie";
         } 

         if (empty($errors)) {
            $query = $db->prepare(
                 'INSERT INTO `movie` (`title`,`released_at`,`description`,`duration`,`cover`,`category_id`)
                 VALUES (:title, :released_at, :description, :duration, :cover, :category_id)');
            $query->bindValue(':title', $title);
            $query->bindValue(':released_at', $released_at);
            $query->bindValue(':description', $description);
            $query->bindValue(':duration', $duration, PDO::PARAM_INT);
            $query->bindValue(':cover', $fileName);            
            $query->bindValue(':category_id', $categorySelected, PDO::PARAM_INT);
            $query->execute();

            echo "<meta http-equiv='refresh' content='0;URL=\"movie_single.php?id=".$db->lastInsertId()."&status=success\"'>";
            //ou header('Location: movie_list.php');
         } else {
            echo "<div class='container alert alert-danger'>";
            foreach($errors as $error) {
                echo "<p class='text-danger m-0'>".$error."</p>";
            }
            echo "</div>";
        }
    }
?>
<div class="container my-4 ">    
    <h1 class="text-center">Ajouter un film</h1>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <form method="POST" enctype="multipart/form-data">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $title; ?>"><br />

                <label for="description">description</label>
                <textarea name="description" id="description" rows="3" class="form-control" ><?= $description; ?></textarea><br />

                <label for="cover">Jaquette</label>
                <input type="file" name="cover" id="cover" class="form-control" ><br /> 

                <label for="duration">Durée</label>
                <input type="number" name="duration" id="duration" class="form-control" value="<?= $duration; ?>"><br />

                <label for="released_at">Sortie</label>
                <input type="date" name="released_at" id="released_at" class="form-control" value="<?= $released_at; ?>"><br />

                <label for="category">Catégorie</label>
                <select name="category" id="category" class="form-control">
                    <?php 
                        foreach(getCategories() as $category) { ?>
                            <option <?php if($category['id'] === $categorySelected) { 
                                echo 'selected'; } ?>
                                value="<?= $category['id']; ?>">
                                <?= $category['name']; ?>
                            </option>
                    <?php  } ?>
                </select><br />

                <button class="btn btn-block btn-danger">Ajouter</button>
            </form>
        </div>
    </div>    
</div>


<?php
    require "../partials/footer.php";
?>