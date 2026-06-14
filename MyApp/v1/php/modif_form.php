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
    <h1>Modifications</h1>

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

        $sql = "SELECT s.SERIE_NOM, s.STATUT_CODE, us.AVANCEE_CODE_AVANCEE, us.COMMENTAIRE
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

        $avancee  = $donnee[0]["AVANCEE_CODE_AVANCEE"];
        $en_cours = ($avancee == "LECTURE_EN_COURS"  || $avancee == "ANIME_EN_COURS");
        $termine  = ($avancee == "LECTURE_TERMINEE"  || $avancee == "ANIME_TERMINE");

        echo '
        <h2>' . htmlspecialchars($donnee[0]['SERIE_NOM']) . ' <small>(' . htmlspecialchars($donnee[0]['STATUT_CODE']) . ')</small></h2>
        <form method="POST" action="exec_modif.php">
            <fieldset>
                <legend>Où en êtes-vous ?</legend>
                <input name="statut_moi" id="jaifini"    type="radio" value="fini"     required' . ($termine              ? " checked" : "") . '>
                <label for="jaifini">J\'ai terminé</label>

                <input name="statut_moi" id="jaipasfini" type="radio" value="pasfini"' . ($en_cours             ? " checked" : "") . '>
                <label for="jaipasfini">Je n\'ai pas terminé</label>

                <input name="statut_moi" id="plustard"   type="radio" value="plustard"' . (!$en_cours && !$termine ? " checked" : "") . '>
                <label for="plustard">Pour plus tard</label>
            </fieldset>
            <fieldset>
                <legend>Commentaire</legend>
                <input name="commentaire" type="text" placeholder="Laissez un commentaire"
                       value="' . htmlspecialchars($donnee[0]['COMMENTAIRE'] ?? '') . '">
            </fieldset>
            <input type="hidden" name="num"  value="' . $numero . '">
            <input type="hidden" name="type" value="' . htmlspecialchars($donnee[0]['STATUT_CODE']) . '">
            <button type="submit">Valider</button>
        </form>';
    }
    ?>
</body>
</html>