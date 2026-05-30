<?php session_start(); ?>
<?php
    include_once "pdo_agile.php";
    include_once "connexion.php";

    $utilisateur_id = $_SESSION["utilisateur_id"];
    $numero = isset($_GET['num']) ? intval($_GET['num']) : 0;
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Détails</title>
</head>
<body>
    <a href="../index.php">Retour à l'accueil</a>
    <br><br>
    <?php
    if ($numero <= 0) {
        echo "<p>Numéro de série invalide.</p>";
        exit;
    }

    $sql = "SELECT s.*, us.AVANCEE_CODE_AVANCEE, us.COMMENTAIRE
            FROM serie s
            INNER JOIN UTILISATEUR_SERIE us
                ON s.SERIE_CODE = us.SERIE_CODE
                AND us.UTILISATEUR_ID = :user_id
            WHERE s.SERIE_CODE = :num";
    $cur = preparerRequetePDO(CONN, $sql);
    majDonneesPrepareesTabPDO($cur, [
        ':user_id' => $utilisateur_id,
        ':num'     => $numero
    ]);
    $donnee = $cur->fetchAll(PDO::FETCH_ASSOC);

    if (empty($donnee)) {
        echo "<p>Série introuvable.</p>";
        exit;
    }

    $media   = ($donnee[0]["STATUT_CODE"] == "MANGA") ? "lire" : "regarder";
    $avancee = ($donnee[0]["AVANCEE_CODE_AVANCEE"] == "ANIME_TERMINE" || $donnee[0]["AVANCEE_CODE_AVANCEE"] == "LECTURE_TERMINEE") ? "finis de" : "commencé à";
    $fin      = $donnee[0]["FIN"] ? "cette série est terminée." : "cette série n'est pas terminée.";
    $nom_serie = htmlspecialchars($donnee[0]["SERIE_NOM"]);
    $statut    = htmlspecialchars(strtolower($donnee[0]["STATUT_CODE"]));

    echo "<p>$nom_serie est un $statut.<br>J'ai $avancee le $media, $fin</p>";
    ?>
    <a href="../html/select.html">Retour à la recherche</a>
</body>
</html>
