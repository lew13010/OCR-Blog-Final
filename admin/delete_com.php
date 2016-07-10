<?php
session_start();
require('../bdd.inc.php');
if(!isset($_SESSION['pseudo']) && !isset($_SESSION['mdp'])){
}else {
    if (isset($_SESSION['token']) AND isset($_GET['token']) AND !empty($_SESSION['token']) AND !empty($_GET['token'])){
        if ($_SESSION['token'] == $_GET['token']) {
                $id = (int) $_GET['id'];
                $req = $bdd->prepare("DELETE FROM commentaires WHERE id=:id");
                $req->bindParam(':id', $id, PDO::PARAM_INT);
                $req->execute();
        }
    }
}
header('Location: index.php');
?>