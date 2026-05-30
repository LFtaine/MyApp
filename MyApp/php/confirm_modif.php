<?php session_start(); ?>

<h1>Confirmation</h1>
<?php

    include_once "pdo_agile.php";
    include_once "connexion.php";

     $utilisateur_id = $_SESSION["utilisateur_id"];

    echo '<meta charset="utf-8"> ';

    if (CONN) {
        afficheDonnees(CONN, $utilisateur_id);
    } else {
        echo ("<hr/> Connexion impossible à la base de données <br/>");
    }

    function afficheDonnees($c, $utilisateur_id) {
        $numero = isset($_GET['num']) ? intval($_GET['num']) : 0;
        if ($numero <= 0) {
            echo "<p>Numéro de série invalide.</p>";
            return;
        }

        // Jointure pour récupérer l'avancée propre à l'utilisateur courant
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

        echo "<h2>Données déjà existantes:</h2>";

        foreach ($donnee as $l) {
            foreach ($l as $propriete => $contenu) {
                if (empty($contenu)) {
                    echo "<br> " . htmlspecialchars($propriete) . " : pas précisé";
                } else {
                    echo "<br> " . htmlspecialchars($propriete) . " : " . htmlspecialchars($contenu);
                }
            }
        }

        $button_ok  = "<br><a href='modif_form.php?num=" . $numero . "'><button>C'est bien celle que je veux</button></a>";
        echo $button_ok;

        $button_non = "<br><a href='../html/modif.html'><button>C'est pas la bonne</button></a>";
        echo $button_non;
    }

    function afficherObj($donnee) {
        echo "<PRE>";
        print_r($donnee);
        echo "</PRE>";
    }
?>
