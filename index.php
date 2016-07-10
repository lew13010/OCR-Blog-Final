<?php
require('bdd.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script type="application/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>Blog</title>
</head>
<body>
<a href="admin">Administration</a>
<div class="container">
    <div class="row">
        <h1 class="text-center">Bienvenue sur le blog</h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <h2>Liste des derniers articles</h2>

        <?php
        $req = $bdd->query('SELECT COUNT(*) FROM articles');
        $nbArt = $req->fetchColumn();
        $req->closeCursor();

        $parPage = 5;
        $nbPage = ceil($nbArt/$parPage);
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page = 1;
        }
        $limit = (int)($page-1)*$parPage;

        if(isset($_GET['page'])){
            $testPage = preg_match('#[0-9]#',$_GET['page']);
            if($_GET['page'] > $nbPage || !$testPage){
                header('Location: index.php');
            }
        }

        $req = $bdd->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT :limit, :parPage");
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->bindParam(':parPage', $parPage, PDO::PARAM_INT);
        $req->execute();
        $articles = $req->fetchAll(PDO::FETCH_ASSOC);

        foreach($articles as $article){
            ?>

        <div>
            <h3><a href="article.php?id=<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['titre']); ?></a></h3>
            <p>
                <?php echo htmlspecialchars($article['contenu']); ?><br>
                <?php echo htmlspecialchars($article['auteur']) . ' - ' . htmlspecialchars($article['date']); ?><br>
                <a href="article.php?id=<?php echo $article['id']; ?>#AjoutCom">Ajouter un commentaire</a>
            </p>
        </div>
        <hr>

        <?php
        }
        $req->closeCursor();
        ?>

        <nav class="text-center">
            <ul class="pagination pagination-sm">
                <?php
                if($nbPage > 1) { //Si 1 seul page alors la pagination ne s'affiche pas.
                    ?>
                    <li>
                        <a href="<?php if(isset($_GET['page']) && $_GET['page'] > 1){echo "index.php?page=".($_GET['page']-1)."";}?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                    for ($i = 1; $i <= $nbPage; $i++) {
                        ?>
                        <li <?php if(isset($_GET['page']) && $_GET['page'] == $i){echo 'class="active"';} ?>><a href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php
                    }
                    ?>
                    <li>
                        <a href="<?php if(isset($_GET['page']) && $_GET['page'] < $nbPage){echo "index.php?page=".($_GET['page']+1)."";}elseif(!isset($_GET['page'])){echo "index.php?page=2";}?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </div>
</div>
</body>
</html>