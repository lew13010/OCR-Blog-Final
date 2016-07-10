<?php
session_start();
require('../bdd.inc.php');
if(!isset($_SESSION['pseudo']) && !isset($_SESSION['mdp'])){
}else {
    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
        if ($_SESSION['token'] == $_POST['token']) {
            if (isset($_POST['titre'])) {
                $id = htmlspecialchars($_POST['id']);
                $titre = htmlspecialchars($_POST['titre']);
                $contenu = htmlspecialchars($_POST['contenu']);
                $auteur = htmlspecialchars($_POST['auteur']);

                $req = $bdd->prepare("UPDATE articles SET titre=:titre, contenu=:contenu, auteur=:auteur WHERE id=$id");
                $req->execute(array(
                    ':titre' => $titre,
                    ':contenu' => $contenu,
                    ':auteur' => $auteur
                ));
                $req->closeCursor();
            }
        }
    }
}
header('Location: index.php');
?>