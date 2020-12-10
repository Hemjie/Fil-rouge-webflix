<?php
    require '../partials/header.php';
?>

<div class="container my-4">    
    <h1 class="text-center">Inscription</h1>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <form method="POST">
                <label for="user">Email ou pseudo</label>
                <input type="text" name="user" id="user" class="form-control" value="<?= $user; ?>"> <br />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control"> <br />   

                <button class="btn btn-block btn-danger">Se connecter</button>
            </form>
        </div>
    </div>    
</div>

<?php
    require '../partials/footer.php';
?>