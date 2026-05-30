<?php session_start(); ?>
<?php
    include_once "pdo_agile.php";
    include_once "connexion.php";

    $utilisateur_id = $_SESSION["utilisateur_id"];
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <a href="../index.php">Retour à l'accueil</a>
    <h1>Confirmation</h1>

    <?php
    if (CONN) {
        afficheDonnees(CONN, $utilisateur_id);
    } else {
        echo "<p>Connexion impossible à la base de données.</p>";
    }

    function afficheDonnees($c, $utilisateur_id) {
        $numero = isset($_GET['num']) ? intval($_GET['num']) : 0;
        if ($numero <= 0) {
            echo "<p>Numéro de série invalide.</p>";
            return;
        }

        $sql = "SELECT s.*, us.AVANCEE_CODE_AVANCEE, us.COMMENTAIRE
                FROM serie s
                INNER JOIN UTILISATEUR_SERIE us
                    ON s.SERIE_CODE = us.SERIE_CODE
                    AND us.UTILISATEUR_ID = :user_id
                WHERE s.SERIE_CODE = :num";
        $cur = preparerRequetePDO($c, $sql);
        majDonneesPrepareesTabPDO($cur, [
            ':user_id' => $utilisateur_id,
            ':num'     => $numero
        ]);
        $donnee = $cur->fetchAll(PDO::FETCH_ASSOC);

        if (empty($donnee)) {
            echo "<p>Série introuvable.</p>";
            return;
        }

        echo "<h2>Données déjà existantes :</h2>";

        foreach ($donnee as $l) {
            foreach ($l as $propriete => $contenu) {
                if (empty($contenu)) {
                    echo "<br>" . htmlspecialchars($propriete) . " : pas précisé";
                } else {
                    echo "<br>" . htmlspecialchars($propriete) . " : " . htmlspecialchars($contenu);
                }
            }
        }

        echo "<br><br><a href='modif_form.php?num=" . $numero . "'><button>C'est bien celle que je veux</button></a>";
        echo "<br><br><a href='../html/modif.html'><button>C'est pas la bonne</button></a>";
    }
    ?>
</body>
</html>
