<?php 
// on inclut ici tous les fichier de configuration du site
require "../config/config.php";
require "../config/database.php";
require "../config/functions.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webflix</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container"> <!-- contenu de la navbar dans un container -->
            <a class="navbar-brand" href="index.php">Webflix</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?= ($pageActive === 'index.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item <?php echo($pageActive === 'movie_list.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="movie_list.php">Nos films</a>
                    </li>
                    <?php
                        /*
                        * 1. On doit écrire ici une requête qui récupère les catégories
                        * 2. Ensuite, on va parcourir le tableau de catégorie et "remplir" le dropdown avec ses catégories
                        * BONUS: Ranger le code PHP dans une fonction getCategories()
                        Idéalement, on met la fonction dans le fichier functions.php à inclure
                        $categories = getCategories()
                        */                    
                    ?>
                    <li class="nav-item dropdown pl-3">
                        <a class="btn btn-outline-danger dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        Nos catégories
                        </a>
                        <div class="dropdown-menu">
                            <?php 
                                foreach(getCategories() as $category) { ?>
                                    <a class="dropdown-item" href="category_single.php?id=<?= $category["id"]; ?>"><?= $category["name"];?></a>
                            <?php } ?>                            
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="movie_search.php">
                    <input class="form-control mr-sm-2" type="search" name="q" placeholder="Rechercher">
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Go</button>
                </form>
                <ul class="navbar-nav ml-4">
                <?php  //si on est connecté, on affiche un menu différent
                    if (isset($_SESSION['user'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                <img src="https://unavatar.now.sh/<?= $_SESSION['user']['email']; ?>" width="40" alt="avatar de l'utilisateur"
                                     class="rounded-circle mr-2">
                                <?= $_SESSION['user']['username']; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if (isAdmin()) { ?>                                    
                                    <a class="dropdown-item" href="movie_add.php">Ajouter un film</a>
                                <?php } ?>
                                <a class="dropdown-item" href="#">Mon compte</a>
                                <a class="dropdown-item" href="logout.php">Déconnexion</a>
                            </div>
                        </li>
                    <?php } else { ?>                        
                        <li class="nav-item">
                            <a href="login.php" class="btn btn-danger">Connexion</a> 
                        </li>
                        <li class="nav-item">
                            <a href="register.php" class="nav-link">Inscription</a> 
                        </li>
                        
                    <?php }
                ?>
                </ul>
            </div>
        </div> <!-- fin du .container -->
    </nav>
