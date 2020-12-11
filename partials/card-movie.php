<div class="col-xl-3 col-lg-4 col-md-6"> <!-- xl: plus de 1200px(pc), lg: 992px(notebook), md: 768px(tablette); sm: 576px(smartphone) -->
    <div class="card shadow mb-4">
        <img src="assets/img/<?= $movie["cover"];?>" class="card-img-top" alt="<?= $movie["title"];?>">
        <div class="card-body">
            <h5 class="card-title"><?= $movie["title"];?></h5>
            <!-- pour l'année, solution en php -->
            <p><strong>Sorti en <?= substr($movie["released_at"], 0, 4);?></strong></p>
            <!-- solution en sql vu dans 14-sql -->
            <!-- Attention commentaire HTML se voit dans inspecteur -->
            <p class="card-text">
                <?= truncate($movie["description"]);?>
            </p>
            <a href="movie_single.php?id=<?= $movie['id'];?>" class="btn btn-danger btn-block">Voir le film</a>
            <?php if (isAdmin()) { ?>                
                <a href="movie_update.php?id=<?= $movie['id'];?>" class="btn btn-secondary btn-block">Modifier</a>
                <a href="movie_delete.php?id=<?= $movie['id'];?>" class="btn btn-secondary btn-block" 
                onclick="/*return confirm('Voulez-vous suprrimer le film')*/"
                data-toggle="modal" data-target="#deleteModal<?= $movie['id']?>">Supprimer</a>
                <!-- Modal -->
                <div class="modal fade" id="deleteModal<?= $movie['id']?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Supprimer <?= $movie['title']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Êtes-vous sûr de vouloir supprimer le film?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                            <a class="btn btn-danger" href="movie_delete.php?id=<?= $movie['id'];?>">Oui</a>
                        </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="card-footer">
            <small class="text-muted">
                <?php                     
                    for ($i = 1; $i <= 5; $i++) {
                        echo ($i <= getAverage($movie['id'])) ? '★' : '☆';
                    } ?>
            </small>
        </div>
    </div>
</div>
