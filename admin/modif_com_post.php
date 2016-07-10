<?php
session_start();
require('../bdd.inc.php');
if(!isset($_SESSION['pseudo']) && !isset($_SESSION['mdp'])){
}else {
    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
        if ($_SESSION['token'] == $_POST['token']) {
            if (isset($_POST['id'])) {
                $id = htmlspecialchars($_POST['id']);
                $pseudo = htmlspecialchars($_POST['pseudo']);
                $email = htmlspecialchars($_POST['email']);
                $contenu = htmlspecialchars($_POST['contenu']);
                $valide = htmlspecialchars($_POST['valide']);

                $req = $bdd->prepare("UPDATE commentaires SET pseudo=:pseudo, email=:email, contenu=:contenu, valide=:valide WHERE id=$id");
                $req->execute(array(
                    ':pseudo' => $pseudo,
                    ':email' => $email,
                    ':contenu' => $contenu,
                    ':valide' => $valide
                ));
                $req->closeCursor();
            }
        }
    }
}
header('Location: index.php');
?>