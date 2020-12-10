<?php
    require '../partials/header.php';

    $email = $password = null;

    if (!empty($_POST)) {
        $errors= [];
        $email = $_POST['email'];        
        $password = trim($_POST['password']);

        $query = $db->prepare('SELECT * FROM `user` WHERE `email` = :email OR `username` = :email');
        $query->bindValue(':email', $email);
        $query->execute();

        $user = $query->fetch();

        if ($user) {
            //on va vérifier la validité du mot de passe entre la saisie et le hash de la base
            if (password_verify($password, $user['password'])) {
                header('Location: login.php?status=success');        
            } else {
                $errors['password'] = "Le mot de passe est incorrect";
            }
        } else {
            $errors['email'] = "L'email ou le pseudo n'existe pas";
        }

        if (!empty($errors)) {            
            echo "<div class='container alert alert-danger'>";
            foreach($errors as $error) {
                echo "<p class='text-danger m-0'>".$error."</p>";
            }
            echo "</div>";
        }
    }

    if(isset($_GET['status']) && $_GET['status'] === 'success') {
        echo '<div class="container alert alert-success"> Vous êtes connecté</div>';
    } else {
?>

<div class="container my-4">    
    <h1 class="text-center">Connexion</h1>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <form method="POST">
                <label for="email">Email ou pseudo</label>
                <input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>"> <br />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control"> <br />   

                <button class="btn btn-block btn-danger">Se connecter</button>
            </form>
        </div>
    </div>    
</div>

<?php }
    require '../partials/footer.php';
?>