<div class="col-xl-3 col-lg-4 col-md-6"> <!-- xl: plus de 1200px(pc), lg: 992px(notebook), md: 768px(tablette); sm: 576px(smartphone) -->
    <div class="card shadow mb-4">
        <img src="assets/img/<?= $movie["cover"];?>" class="card-img-top" alt="<?= $movie["title"];?>">
        <div class="card-body">
            <h5 class="card-title"><?= $movie["title"];?></h5>
            <!-- pour l'année, solution en php -->
            <p><strong>Sorti en <?= substr($movie["released_at"], 0, 4);?></strong></p>
            <!-- solution en sql vu dans 14-sql -->
            <!-- Attention commentaire HTML se voit dans inspecteur -->
            <p class="card-text"><?= $movie["description"];?></p>
            <a href="movie_single.php?id=<?= $movie['id'];?>" class="btn btn-danger btn-block">Voir le film</a>
        </div>
        <div class="card-footer">
            <small class="text-muted">★★★★☆</small>
        </div>
    </div>
</div>
