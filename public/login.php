<?php
    require '../partials/header.php';

    $email = $password = null;

    if (!empty($_POST)) {
        $errors= null;
        $email = $_POST['email'];        
        $password = trim($_POST['password']);

        $query = $db->prepare('SELECT * FROM `user` WHERE `email` = :email OR `username` = :email');
        $query->bindValue(':email', $email);
        $query->execute();

        $user = $query->fetch();

        if ($user) {
            //on va vérifier la validité du mot de passe entre la saisie et le hash de la base
            if (password_verify($password, $user['password'])) {  
                //pour garder l'utilisateur connecté, on va le mettre dans la session           
                unset($user['password']); //on ne stocke pas le hash avec la session       
                $_SESSION['user'] = $user; 

                header('Location: index.php?status=success');   
            } else {
                $errors = "L'email et/ou le mot de passe est incorrect";
            }
        } else {
            $errors = "L'email et/ou le mot de passe est incorrect";
        }

        if (!empty($errors)) {            
            echo "<div class='container alert alert-danger'>";
            echo "<p class='text-danger m-0'>".$errors."</p>";
            }
            echo "</div>";
    }
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

<?php
    require '../partials/footer.php';
?>