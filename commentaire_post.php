<?php
require('bdd.inc.php');

if(isset($_POST['comment']) && $_POST['comment'] != ''){
    $id = $_POST['idArt'];
    $pseudo = $_POST['name'];
    $email = $_POST['email'];
    $contenu = $_POST['comment'];

    $req = $bdd->prepare('INSERT INTO commentaires (pseudo, email, contenu, id_articles, date_com) VALUES(?, ?, ?, ?, NOW())');
    $req->execute(array($pseudo,$email,$contenu,$id));
    $req->closeCursor();
}
header('Location: article.php?id='.$id);
?>