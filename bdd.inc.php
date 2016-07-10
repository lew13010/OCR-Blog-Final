<?php
//Elements BDD
    $host    =  "localhost";
    $db_name =  "blog";
    $login   =  "root";
    $pass    =  "";

//Connexion BDD
// Gestion d'erreur SQL = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
// Gestion UTF8 SQL = array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    try
    {
        $bdd = new PDO("mysql:host=".$host.";dbname=".$db_name, $login, $pass, array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
?>