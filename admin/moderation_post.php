<?php
session_start();
require('../bdd.inc.php');

if(isset($_POST['moderation']) && $_POST['moderation'] != ''){
    $mod = $_POST['moderation'];
    $req = $bdd->prepare("UPDATE `mod_com` SET `mod`=:mod WHERE  `id`=1");
    $req->bindParam(':mod', $mod, PDO::PARAM_STR);
    $req->execute();
}

header('Location: admin.php');

?>