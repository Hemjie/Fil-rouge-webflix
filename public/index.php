    <?php
        require "../partials/header.php";

        // Comment faire une requête avec le PDO?
        // Méthode query renvoie un objet PDOStatement
        $query = $db->query("SELECT * FROM category"); // Accès à la requête
        
        // fetchAll renvoie un tableau qui contient toutes les lignes de résultat de la requête 
        $categories = $query->fetchAll();

        // Possible de le faire en une seule ligne
        // $categories =  $db->query("SELECT * FROM category")->fetchAll();

        // On va parcourir les catégories
        // RAPPEL: <?= équivaut à <?php echo
        echo "<div class='row'>";
        foreach ($categories as $category) { ?>
            <div class="col-6">
                <h1><?= $category["name"]; ?></h1>
            </div>
        <?php }
        echo "</div>";

        require "../partials/footer.php";
    ?>