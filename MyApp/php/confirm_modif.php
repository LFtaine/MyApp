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
    <title>Confirmation</title>
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

        $sql = "SELECT
                    s.SERIE_NOM,
                    st.STATUT_LIBELLLE  AS TYPE_LIBELLE,
                    s.SERIE_DATE_D,
                    s.SERIE_DATE_F,
                    s.FIN,
                    av.AVANCEE_LIBELLE,
                    us.COMMENTAIRE
                FROM serie s
                INNER JOIN STATUT st
                    ON s.STATUT_CODE = st.STATUT_CODE
                INNER JOIN UTILISATEUR_SERIE us
                    ON s.SERIE_CODE = us.SERIE_CODE
                    AND us.UTILISATEUR_ID = :user_id
                INNER JOIN AVANCEE av
                    ON us.AVANCEE_CODE_AVANCEE = av.AVANCEE_CODE_AVANCEE
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

        $d = $donnee[0];

        // Dates
        $date_debut = !empty($d['SERIE_DATE_D']) ? $d['SERIE_DATE_D'] : "Non précisée";
        $date_fin   = !empty($d['SERIE_DATE_F']) ? $d['SERIE_DATE_F'] : "Non précisée";
        $terminee   = $d['FIN'] == 1 ? "Oui" : "Non";
        $commentaire = !empty($d['COMMENTAIRE']) ? htmlspecialchars($d['COMMENTAIRE']) : "Aucun";

        echo "
        <section>
            <h2>" . htmlspecialchars($d['SERIE_NOM']) . "</h2>

            <h3>Informations générales</h3>
            <p><strong>Type :</strong> " . htmlspecialchars($d['TYPE_LIBELLE']) . "</p>
            <p><strong>Date de début :</strong> " . htmlspecialchars($date_debut) . "</p>
            <p><strong>Date de fin :</strong> " . htmlspecialchars($date_fin) . "</p>
            <p><strong>Série terminée :</strong> " . $terminee . "</p>

            <h3>Votre suivi</h3>
            <p><strong>Avancement :</strong> " . htmlspecialchars($d['AVANCEE_LIBELLE']) . "</p>
            <p><strong>Commentaire :</strong> " . $commentaire . "</p>
        </section>

        <br>
        <a href='modif_form.php?num=" . $numero . "'><button>C'est bien celle que je veux</button></a>
        <a href='../html/modif.html'><button>C'est pas la bonne</button></a>
        ";
    }
    ?>
</body>
</html>