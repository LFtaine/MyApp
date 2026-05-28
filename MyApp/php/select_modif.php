<?php

    include_once "pdo_agile.php";
    include_once "connexion.php";
    echo '<meta charset="utf-8"> ';

    if (CONN) {
        echo "<a href='../index.html'>Retour à l'accueil</a>";

        $nom = isset($_POST["nom"]) ? trim(strip_tags($_POST["nom"])) : "";

        if (!empty($nom)) {
            lireDonneesTexte(CONN, $nom);
        }
    } else {
        echo ("<hr/> Connexion impossible à la base de données <br/>");
    }

    function lireDonneesTexte($c, $texte) {
        // Requête préparée avec LIKE et paramètre lié
        $sql = "SELECT * FROM serie WHERE lower(SERIE_NOM) LIKE lower(:search) ORDER BY serie_nom";
        $cur = preparerRequetePDO($c, $sql);
        majDonneesPrepareesTabPDO($cur, [':search' => '%' . $texte . '%']);
        $donnee = $cur->fetchAll(PDO::FETCH_ASSOC);

        if (empty($donnee)) {
            echo "<br>Aucune série correspondante";
            return;
        }

        foreach ($donnee as $l) {
            if ($l["STATUT_CODE"] == "MANGA") {
                $media = "lire";
            } else {
                $media = "regarder";
            }

            if ($l["AVANCEE_CODE_AVANCEE"] == "ANIME_TERMINE" || $l["AVANCEE_CODE_AVANCEE"] == "LECTURE_TERMINEE") {
                $avancee = "finis de";
            } else {
                $avancee = "commencé à";
            }

            $fin  = $l["FIN"] ? "cette série est terminée." : "cette série n'est pas terminée.";
            $page = "confirm_modif.php?num=" . intval($l["SERIE_CODE"]);
            $nom_affiche = htmlspecialchars($l["SERIE_NOM"]);
            $statut      = htmlspecialchars(strtolower($l["STATUT_CODE"]));

            echo "<p>La série s'appelle <a href='$page'>$nom_affiche</a> c'est un $statut et j'ai $avancee la $media, $fin</p>";
        }
    }

    function afficherObj($obj) {
        echo "<PRE>";
        print_r($obj);
        echo "</PRE>";
    }
?>
