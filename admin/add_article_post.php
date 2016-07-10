<?php
session_start();
require('../bdd.inc.php');
if(!isset($_SESSION['pseudo']) && !isset($_SESSION['mdp'])){
}else {
    if(isset($_POST['titre']) && $_POST['titre'] != '' && $_POST['contenu'] != '' && $_POST['auteur'] != ''){
        $id = htmlspecialchars($_POST['id']);
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = htmlspecialchars($_POST['contenu']);
        $auteur = htmlspecialchars($_POST['auteur']);

        $req = $bdd->prepare("INSERT INTO articles (titre, contenu, auteur, date) VALUES (?, ?, ?, NOW())");
        $req->execute(array($titre, $contenu, $auteur));
        $req->closeCursor();
    }
}
header('Location: index.php');
?>