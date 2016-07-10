<?php
session_start();
require('../bdd.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script type="application/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>Administration</title>
</head>
<body>
<a href="../">Retour blog</a>
<div class="container">
    <div class="row">
        <?php
            if(isset($_SESSION['pseudo']) && isset($_SESSION['mdp'])){
                header('Location: admin.php');
            }
            else {
                if (isset($_POST['login']) && isset($_POST['password']) && $_POST['login'] != '' && $_POST['password'] != '') {
                    $pseudo = $_POST['login'];
                    $password = md5($_POST['password']);
                    $req = $bdd->prepare("SELECT * FROM admin WHERE pseudo=? AND mdp=?");
                    $req->execute(array($pseudo,$password));
                    $connexion = $req->fetchColumn();
                    $req->closeCursor();
                    if($connexion){
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['mdp'] = $password;
                        header('Location: admin.php');
                    }
                }
            }
            ?>
        <form method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" name="login" id="login" placeholder="Login">
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" name="password" id="Password"
                       placeholder="Password">
            </div>
            <button type="submit" class="btn btn-default">Valider</button>
        </form>
    </div>
</div>

</body>
</html>