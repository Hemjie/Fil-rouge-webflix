<?php
    require '../partials/header.php';

    /**
     * Inscription de l'utilisateur
     * 1. on récupère 4 champs: email, username, password et cf-password
     * 2. on vérifie email(valide et unique dans la bdd), pseudo (pas vide et unique dans la bdd), et le mot de passe
     * 3. password doit avoir la même valeur que cf-password(minimum 8 caractères dont 1 chiffre et 1 caractère spécial)
     * 4. On ajoute l'utilisateur dans la bdd et on fait qqch pour le mdp
     */

    $email = $username = $password = $cf_password = null;

    // pour sécuriser les mdp: password_hash
    // cette fonction utilise l'algo BCRYPT ou ARGON2
    // $password = 'test';
    // $hash = password_hash($password, PASSWORD_DEFAULT);

    // echo "le hash ".$hash." correspond au mot de passe ".$password;

    if (!empty($_POST)) {
        $errors= [];
        $email = $_POST['email'];
        $username = htmlspecialchars($_POST['username']);
        $password = trim($_POST['password']);
        $cf_password = trim($_POST['cf-password']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email n'est pas valide";
        }

        if(empty($username)) {
            $errors['username'] = "Le pseudo est obligatoire";
        }

        // vérifie que l'utilisateur n'existe pas déjà
        $query = $db->prepare(
            'SELECT * FROM `user` WHERE `email` = :email OR `username` = :username'
        );
        $query->bindValue(':email', $email);
        $query->bindValue(':username', $username);
        $query->execute();

        $user = $query->fetch(); //renvoie un tableau si user existe ou false

        if ($user) {
            $errors['user'] = "L'email ou le pseudo est déjà pris";
        }
        
        if (strlen($password) < 8 ) {
            $errors['password_1'] = "Le mot de passe doit contenir au minimum 8 caractères";
        }

        // Les Regex permettent de valider un "format" de chaine
        // (+33 [1-9]|0[1-9])([.- ]?[0-9]{2}){4} valide un téléphone :
        // 0612345678
        // 06.12.34.56.78
        // 06-12-34-56-78
        // 09 12 34 56 78
        // +33 6 12 34 58 64
        // 06 12 45 65 74
        // +33 7 45 74 14 4

        // [0-9]+ vérifie qu'une chaine contient un nombre au moins une fois
        // [[:punct:]]+ ou [^a-zA-Z0-9]+ vérifie qu'une chaine contient un caractère spécial au moins une fois
        if (!preg_match('/[0-9]+/', $password)) {
            $errors['password_2'] = "Le mot de passe doit contenir au moins un chiffre";
        }

        if (!preg_match('/[[:punct:]]+/', $password)) {
            $errors['password_3'] = "Le mot de passe doit contenir au moins un caractère spécial";
        }    
        
        if($password !== $cf_password) {
            $errors['password_4'] = "Les mots de passe ne correspondent pas";
        }

        if (empty($errors)) {
            //inscription: requête SQL
            $query = $db->prepare(
                'INSERT INTO `user` (`email`,`username`,`password`)
                VALUES(:email, :username, :password);'
            );
            $query->bindValue(':email', $email);
            $query->bindValue(':username', $username);
            $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT)); //on stocke le hash dans la BDD
            $query->execute();

            // on redirige et on cache le formulaire?
            header('Location: register.php?status=success');            

        } else {
            echo "<div class='container alert alert-danger'>";
            foreach($errors as $error) {
                echo "<p class='text-danger m-0'>".$error."</p>";
            }
            echo "</div>";
        }
    }
    
    if(isset($_GET['status']) && $_GET['status'] === 'success') {
        echo '<div class="container alert alert-success"> Vous êtes bien inscrit</div>';
    } else {
?>

<div class="container my-4">    
    <h1 class="text-center">Inscription</h1>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <form method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $email; ?>"> <br />

                <label for="username">Pseudo</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= $username; ?>"> <br />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control"> <br />

                <label for="cf-password"> Confirmez le mot de passe</label>
                <input type="password" name="cf-password" id="cf-password" class="form-control"> <br />              

                <button class="btn btn-block btn-danger">S'inscrire</button>
            </form>
        </div>
    </div>    
</div>

<?php }
    require '../partials/footer.php';
?>