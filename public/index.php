    <?php
        require "../partials/header.php";

        // Comment faire une requête avec le PDO?
        // Méthode query renvoie un objet PDOStatement
        // $query = $db->query("SELECT * FROM category"); // Accès à la requête
        
        // fetchAll renvoie un tableau qui contient toutes les lignes de résultat de la requête 
        // $categories = $query->fetchAll();

        // Possible de le faire en une seule ligne
        // $categories =  $db->query("SELECT * FROM category")->fetchAll();

        // On va parcourir les catégories
        // RAPPEL: <?= équivaut à <?php echo
        /* echo "<div class='row'>";
        foreach ($categories as $category) { ?>
            <div class="col-6">
                <h1><?= $category["name"]; ?></h1>
            </div>
        <?php }
        echo "</div>"; */

        /* 
        * 1. Sur cette page, on doit afficher 4 films aléatoires de la bdd
        * 2. On affichera bien une div row de 4 div col-3 sur la page
        * 3. On utilisera le card de bootstrap pour les films
        * 4. Pour les images, on utilisera le champ cover de la BDD
        * ☆★
        */
    ?>
    <div class="container">
        <h1>Sélection de films aléatoires</h1>
        <div class="row">
            <?php
            foreach(get4Movies() as $movie) { ?>
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/<?= $movie["cover"]?>" class="card-img-top" alt="<?= $movie["title"]?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $movie["title"]?></h5>
                            <!-- pour l'année, solution en php -->
                            <p><strong>Sorti en <?= substr($movie["released_at"], 0, 4)?></strong></p>
                            <!-- solution en sql vu dans 14-sql -->
                            <p class="card-text"><?= $movie["description"]?></p>
                            <a href="#" class="btn btn-danger btn-block">Voir le film</a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">★★★★☆</small>
                        </div>
                    </div>
                </div>
           <?php } ?>        
        </div>
    </div>
   
    <?php
        require "../partials/footer.php";
    ?>