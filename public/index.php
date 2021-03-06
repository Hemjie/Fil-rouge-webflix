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

        /* CAROUSEL
        * 1. On va déposer le carousel des films ci-dessous
        * Par défaut, on utilise Bootstrap et on va afficher 3 jacquettes par slide (voir vidéo)
        * On aura 3 slides donc 9 films ce qui veut dire qu'on doit écrire une requête SQL pour récupérer les 9 films les plus récents et qui contient une jacquette donc dont le champ est cover est non null
        * Pour la boucle, on part d'un tableau de 9 éléments et on doit l'afficher dans le code HTML
        */
    ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">          
                <?php
                foreach(getCarousel() as $index => $movie) {  
                    if($index % 3 === 0) { ?>
                         <!-- On peut écrire un if sur une seule ligne grâce au ternaire -->
                        <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?> ">
                            <div class="d-flex">
                <?php }  ?>

                                <img src="assets/img/<?= $movie["cover"];?>" class="d-block" alt="<?= $movie["title"];?>">

                <?php if (($index + 1) % 3 === 0  || ($index + 1) === count($carouselMovies)) { ?>
                            </div>
                        </div>
                <?php }  ?>
            <?php }  ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <?php /* AUTRE METHODE POUR LE CAROUSEL
    <?php foreach ([0, 3, 6] as $key) { ?>
        <div class="carousel-item <?php if ($key === 0) { echo 'active'; } ?>">
            <div class="d-flex">
                <img src="assets/uploads/<?= $carouselMovies[$key]['cover']; ?>" class="d-block" alt="<?= $carouselMovies[$key]['title']; ?>">
                <img src="assets/uploads/<?= $carouselMovies[$key+1]['cover']; ?>" class="d-block" alt="<?= $carouselMovies[$key+1]['title']; ?>">
                <img src="assets/uploads/<?= $carouselMovies[$key+2]['cover']; ?>" class="d-block" alt="<?= $carouselMovies[$key+2]['title']; ?>">
            </div>
        </div>
    <?php } ?> */ ?>

    <?php
        /* 
        * 1. Sur cette page, on doit afficher 4 films aléatoires de la bdd
        * 2. On affichera bien une div row de 4 div col-3 sur la page
        * 3. On utilisera le card de bootstrap pour les films
        * 4. Pour les images, on utilisera le champ cover de la BDD
        * ☆★
        */
        
        //si l'utilisateur vient de se connecter
        if(isset($_GET['status']) && $_GET['status'] === 'success') {
        echo '<div class="container alert alert-success"> Vous êtes bien connecté</div>';
        } 
    ?>
    
    <div class="container mt-4 mb-5">
        <h2>Sélection de films aléatoires</h2>
        <div class="row">
            <?php
            foreach(get4Movies() as $movie) { 
                require "../partials/card-movie.php";
            } ?>        
        </div>
    </div>
   
    <?php
        require "../partials/footer.php";
    ?>
