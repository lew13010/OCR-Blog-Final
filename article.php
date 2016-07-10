<?php
require('bdd.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script type="application/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>Articles</title>
</head>
<body>
<div class="container">
    <div class="row">
        <h1 class="text-center">Bienvenue sur le blog</h1>
    </div>
</div>

<?php
if(!isset($_GET['id']) && $_GET['id'] == ''){
    header('Location: index.php');
}else{
?>
<div class="container">
    <div class="row">
        <?php
        $id = (int)$_GET['id'];
        $req = $bdd->prepare("SELECT * FROM articles WHERE id=:id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
        if($req){
            $articles = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
            if($articles){
                foreach ($articles as $article) {
                    ?>

                    <div>
                        <h2><?php echo $article['titre']; ?></h2>
                        <p>
                            <?php echo $article['contenu']; ?><br>
                            <?php echo $article['auteur'] . ' - ' . $article['date']; ?>
                        </p>
                    </div>
                    <?php
                }
                ?>
                <hr>
                <div>
                    <h2 class="text-center">Liste des commentaires</h2>
                    <?php
                    $req = $bdd->query('SELECT * FROM mod_com WHERE id=1');
                    $moderation = $req->fetch(PDO::FETCH_ASSOC);
                    $req->closeCursor();

                    if ($moderation['mod'] == '0') {
                        $req = $bdd->prepare("SELECT * FROM commentaires WHERE id_articles=:id");
                        $req->bindParam(':id', $id, PDO::PARAM_INT);
                        $req->execute();
                    } else {
                        $req = $bdd->prepare("SELECT * FROM commentaires WHERE id_articles=:id AND valide='1'");
                        $req->bindParam(':id', $id, PDO::PARAM_INT);
                        $req->execute();
                    }
                    $commentaires = $req->fetchAll(PDO::FETCH_ASSOC);
                    $req->closeCursor();

                    foreach ($commentaires as $commentaire) {
                        ?>

                        <div class="col-md-3 text-center">
                            <?php if ($commentaire['email'] != '') {
                                $hash = md5(strtolower(trim($commentaire['email'])));
                                echo '<img src="https://www.gravatar.com/avatar/' . $hash . '?s=75" alt="" width="75"/>';
                            } else {
                                echo '<img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?s=75" alt="" width="75"/>';
                            }
                            ?>
                            <p><b><?php if ($commentaire['pseudo'] == '') {
                                        echo 'Anonyme';
                                    } else {
                                        echo htmlspecialchars($commentaire['pseudo']);
                                    } ?></b></p>
                            <p><?php echo htmlspecialchars($commentaire['email']); ?></p>
                            <p><?php echo htmlspecialchars($commentaire['date_com']); ?></p>
                        </div>
                        <div class="col-md-9">
                            <?php echo htmlspecialchars($commentaire['contenu']); ?>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                    }
                    ?>
                </div>
                <hr>
                <div>
                    <h2 class="text-center" id="AjoutCom">Ajouter un commentaire</h2>
                    <form action="commentaire_post.php" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">nom :</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="name" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="email">email :</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" id="email" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="comment">Commentaire :</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="comment" id="comment" required></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="idArt" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <input class="btn btn-default" type="submit" value="Valider">
                            </div>
                        </div>
                    </form>
                    <a href="index.php"><- Revenir à l'accueil</a>
                </div>
                <?php
                }else{header('Location: erreur.php');}
            }else{header('Location: erreur.php');}
        }
        ?>
    </div>
</div>
</body>
</html>