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
    <link rel="icon" type="image/x-icon" href="../images/icone.ico">
    <title>Modification</title>
</head>
<body>
    <a href="../index.php">Retour à l'accueil</a>

    <?php
    $types_autorises   = ["MANGA", "ANIME", "MANWHA", "LN", "LIVE_ACTION"];
    $statuts_autorises = ["fini", "pasfini", "plustard"];

    if (!isset($_POST["num"], $_POST["type"], $_POST["statut_moi"])) {
        echo "<p>Il manque des champs obligatoires !</p>";
        exit;
    }

    $numero      = intval($_POST["num"]);
    $type        = $_POST["type"];
    $fini        = $_POST["statut_moi"];
    $commentaire = isset($_POST["commentaire"]) ? trim(strip_tags($_POST["commentaire"])) : "";

    if ($numero <= 0) {
        echo "<p>Numéro de série invalide.</p>";
        exit;
    }
    if (!in_array($type, $types_autorises)) {
        echo "<p>Type de série invalide.</p>";
        exit;
    }
    if (!in_array($fini, $statuts_autorises)) {
        echo "<p>Statut invalide.</p>";
        exit;
    }

    // Calcul du code d'avancée selon le type et le statut
    if ($type === "ANIME") {
        if ($fini === "fini")          $statut = "ANIME_TERMINE";
        elseif ($fini === "plustard")  $statut = "PLUS_TARD_A";
        else                           $statut = "ANIME_EN_COURS";
    } else {
        if ($fini === "fini")          $statut = "LECTURE_TERMINEE";
        elseif ($fini === "plustard")  $statut = "PLUS_TARD_M";
        else                           $statut = "LECTURE_EN_COURS";
    }

    $requete = "UPDATE UTILISATEUR_SERIE
                SET AVANCEE_CODE_AVANCEE = :avancee,
                    COMMENTAIRE = :commentaire
                WHERE UTILISATEUR_ID = :user_id
                AND   SERIE_CODE     = :serie_code";

    $cur = preparerRequetePDO(CONN, $requete);
    majDonneesPrepareesTabPDO($cur, [
        ':avancee'     => $statut,
        ':commentaire' => !empty($commentaire) ? $commentaire : null,
        ':user_id'     => $utilisateur_id,
        ':serie_code'  => $numero
    ]);

    echo "<p>Série mise à jour avec succès !</p>";
    
    ?>
</body>
</html>