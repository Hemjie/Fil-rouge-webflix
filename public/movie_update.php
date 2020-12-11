<?php
    require "../partials/header.php";

    if (!isAdmin()) {
        display403();
    } 

    if (isset($_GET['id'])) {
        $id_movie = $_GET['id'];
    } else {
        display404();
    }

    $movie = getMovie($id_movie);
    if (!getMovie($id_movie)) {
        display404();
    }

    $title = $movie['title'];
    $description = $movie['description'];
    $cover = $movie['cover'];
    $duration = $movie['duration'];
    $released_at = $movie['released_at'];
    $categorySelected = $movie['category_id'];
    
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
        } else if ($cover["error"] === 4) {  //si on n'uploade pas une nouvelle jacquette, error = 4, quand on ne fait pas d'upload
            $fileName = $movie['cover'] ;
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
                 'UPDATE `movie`
                  SET `title` = :title, `released_at` = :released_at, `description` = :description, 
                      `duration` = :duration, `cover` = :cover, `category_id` = :category_id 
                  WHERE id = :movie_id');
            $query->bindValue(':title', $title);
            $query->bindValue(':released_at', $released_at);
            $query->bindValue(':description', $description);
            $query->bindValue(':duration', $duration, PDO::PARAM_INT);
            $query->bindValue(':cover', $fileName);            
            $query->bindValue(':category_id', $categorySelected, PDO::PARAM_INT);
            $query->bindValue(':movie_id', $id_movie, PDO::PARAM_INT);
            $query->execute();

            echo "<meta http-equiv='refresh' content='0;URL=\"movie_single.php?id=".$id_movie."&status=updated\"'>";
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
    <div class="row">
        <h1 class="text-center">Modifier un film</h1>
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

                <button class="btn btn-block btn-danger">Valider</button>
            </form>
        </div>
    </div>    
</div>

<?php
    require "../partials/footer.php";
?>
