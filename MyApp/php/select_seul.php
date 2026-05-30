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

    <?php
    if (CONN) {
        $nom = isset($_POST["nom"]) ? trim(strip_tags($_POST["nom"])) : "";
        if (!empty($nom)) {
            lireDonneesTexte(CONN, $nom, $utilisateur_id);
        }
    } else {
        echo "<p>Connexion impossible à la base de données.</p>";
    }

    function lireDonneesTexte($c, $texte, $utilisateur_id) {
        $sql = "SELECT s.*, us.AVANCEE_CODE_AVANCEE, us.COMMENTAIRE
                FROM serie s
                INNER JOIN UTILISATEUR_SERIE us
                    ON s.SERIE_CODE = us.SERIE_CODE
                    AND us.UTILISATEUR_ID = :utilisateur_id
                WHERE lower(s.SERIE_NOM) LIKE lower(:search)
                ORDER BY s.SERIE_NOM";
        $cur = preparerRequetePDO($c, $sql);
        majDonneesPrepareesTabPDO($cur, [
            ':utilisateur_id' => $utilisateur_id,
            ':search'         => '%' . $texte . '%'
        ]);
        $donnee = $cur->fetchAll(PDO::FETCH_ASSOC);

        if (empty($donnee)) {
            echo "<p>Aucune série correspondante.</p>";
            return;
        }

        foreach ($donnee as $l) {
            $media   = ($l["STATUT_CODE"] == "MANGA") ? "lire" : "regarder";
            $avancee = ($l["AVANCEE_CODE_AVANCEE"] == "ANIME_TERMINE" || $l["AVANCEE_CODE_AVANCEE"] == "LECTURE_TERMINEE") ? "finis de" : "commencé à";
            $fin         = $l["FIN"] ? "cette série est terminée." : "cette série n'est pas terminée.";
            $page        = "details.php?num=" . intval($l["SERIE_CODE"]);
            $nom_affiche = htmlspecialchars($l["SERIE_NOM"]);
            $statut      = htmlspecialchars(strtolower($l["STATUT_CODE"]));

            echo "<p>La série s'appelle <a href='$page'>$nom_affiche</a> c'est un $statut et j'ai $avancee la $media, $fin</p>";
        }
    }
    ?>
</body>
</html>
