<?php
session_start();
require('../bdd.inc.php');
if(!isset($_SESSION['pseudo']) && !isset($_SESSION['mdp'])){
    header('Location: index.php');
}else {
    $token = md5(bin2hex(openssl_random_pseudo_bytes(5)));
    $_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script   src="https://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>
    <script type="application/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>Administration</title>
</head>
<body>
<a href="deconnexion.php">Deconnexion</a> - <a href="../">Retour blog</a>
<div class="container">
    <div class="row">
    <h2>Gestion des articles</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>id</th>
            <th>Titre</th>
            <th>Contenu</th>
            <th>Auteur</th>
            <th>Date</th>
            <th>Modifier</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $req = $bdd->query('SELECT * FROM articles ORDER BY id DESC');
        $articles = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        foreach ($articles as $article) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($article['id']); ?></td>
                <td><?php echo htmlspecialchars($article['titre']); ?></td>
                <td><?php echo htmlspecialchars($article['contenu']); ?></td>
                <td><?php echo htmlspecialchars($article['auteur']); ?></td>
                <td><?php echo htmlspecialchars($article['date']); ?></td>
                <td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalArt<?php echo $article['id']; ?>">Modifier</button></td>
            </tr>

            <!-- MODAL MODIFIER ARTICLES  -->
            <div class="modal fade" id="modalArt<?php echo $article['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Modifier Article : <?php echo htmlspecialchars($article['titre']); ?></h4>
                        </div>
                        <form action="modif_article_post.php" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contenu">Contenu</label>
                                    <textarea name="contenu" id="contenu" class="form-control" cols="50" rows="10"><?php echo htmlspecialchars($article['contenu']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="auteur">Auteur</label>
                                    <input type="text" class="form-control" id="auteur" name="auteur" value="<?php echo htmlspecialchars($article['auteur']); ?>">
                                </div>
                                <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                                <input type="hidden" name="token" value="<?php echo $token; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <a href="delete_article.php?id=<?php echo $article['id']; ?>&token=<?php echo $token; ?>"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </tbody>
    </table>
    <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#modalAddArt">Ajouter un Article</button>
        <div class="clearfix"></div>
        <!-- MODAL AJOUTER ARTICLES  -->
        <div class="modal fade" id="modalAddArt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Ajouter un Article</h4>
                    </div>
                    <form action="add_article_post.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="titre">Titre</label>
                                <input type="text" class="form-control" id="titre" name="titre" required>
                            </div>
                            <div class="form-group">
                                <label for="contenu">Contenu</label>
                                <textarea name="contenu" id="contenu" class="form-control" cols="50" rows="10" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="auteur">Auteur</label>
                                <input type="text" class="form-control" id="auteur" name="auteur" value="" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <hr>
    <h2>Gestion des commentaires</h2>
    <?php
    $req = $bdd->query("SELECT * FROM mod_com WHERE id=1");
    $result = $req->fetch(PDO::FETCH_ASSOC);
    $req->closeCursor();
    $mod = $result['mod'];

    ?>
    <form action="moderation_post.php" method="post" class="form-inline">
        Les commentaires doivent-ils être moderé ?
        <div class="radio-inline">
            <label>
                <input type="radio" name="moderation" id="option1" value="0" <?php if ($mod == 0) {
                    echo 'checked';
                } ?>>
                Non
            </label>
        </div>
        <div class="radio-inline">
            <label>
                <input type="radio" name="moderation" id="option2" value="1" <?php if ($mod == 1) {
                    echo 'checked';
                } ?>>
                Oui
            </label>
        </div>
        <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
        <div class="radio-inline">
            <button type="submit" class="btn btn-default btn-xs">Valider</button>
        </div>
    </form>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>id</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Contenu</th>
            <th>Articles</th>
            <th>Validé</th>
            <th>Modifier</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $req = $bdd->query('SELECT * FROM commentaires ORDER BY id DESC');
        $commentaires = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        foreach ($commentaires as $commentaire) {
            ?>
            <tr>
                <td><?php echo $commentaire['id']; ?></td>
                <td><?php echo htmlspecialchars($commentaire['pseudo']); ?></td>
                <td><?php echo htmlspecialchars($commentaire['email']); ?></td>
                <td><?php echo htmlspecialchars($commentaire['contenu']); ?></td>
                <td><?php echo htmlspecialchars($commentaire['id_articles']); ?></td>
                <td><?php if ($commentaire['valide'] == 1) {
                        echo 'oui';
                    } else {
                        echo 'non';
                    } ?></td>
                <td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalCom<?php echo $commentaire['id']; ?>">Modifier</button></td>
            </tr>
            <!-- MODAL MODIFIER COMMENTAIRE  -->
            <div class="modal fade" id="modalCom<?php echo $commentaire['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Modifier Commentaire : <?php echo htmlspecialchars($commentaire['pseudo']); ?></h4>
                        </div>
                        <form action="modif_com_post.php" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="pseudo">pseudo</label>
                                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($commentaire['pseudo']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($commentaire['email']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contenu">Contenu</label>
                                    <textarea name="contenu" id="contenu" class="form-control" cols="50" rows="10"><?php echo htmlspecialchars($commentaire['contenu']); ?></textarea>
                                </div>
                                Valide :
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="valide" id="option1" value="0" <?php if ($commentaire['valide'] == 0) {
                                            echo 'checked';
                                        } ?>>
                                        Non
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="valide" id="option2" value="1" <?php if ($commentaire['valide'] == 1) {
                                            echo 'checked';
                                        } ?>>
                                        Oui
                                    </label>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $commentaire['id']; ?>">
                                <input type="hidden" name="token" value="<?php echo $token; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <a href="delete_com.php?id=<?php echo $commentaire['id']; ?>&token=<?php echo $token; ?>"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>
    </div>
</div>
</body>
</html>
