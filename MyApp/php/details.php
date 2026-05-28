<?php
    include_once "pdo_agile.php";
    include_once "connexion.php";
    echo '<meta charset="utf-8"> ';

    $accueil = "../index.html";
    echo "<br><a href='" . $accueil . "'>Retour à l'accueil</a>";

    // Validation : $num doit être un entier
    $numero = isset($_GET['num']) ? intval($_GET['num']) : 0;
    if ($numero <= 0) {
        echo "<p>Numéro de série invalide.</p>";
        exit;
    }

    $sql = "SELECT * FROM serie WHERE serie_code = :num";
    $cur = preparerRequetePDO(CONN, $sql);
    majDonneesPrepareesTabPDO($cur, [':num' => $numero]);
    $donnee = $cur->fetchAll(PDO::FETCH_ASSOC);

    if (empty($donnee)) {
        echo "<p>Série introuvable.</p>";
        exit;
    }

    if ($donnee[0]["STATUT_CODE"] == "MANGA") {
        $media = "lire";
    } else {
        $media = "regarder";
    }

    if ($donnee[0]["AVANCEE_CODE_AVANCEE"] == "ANIME_TERMINE" || $donnee[0]["AVANCEE_CODE_AVANCEE"] == "LECTURE_TERMINEE") {
        $avancee = "finis de";
    } else {
        $avancee = "commencé à";
    }

    if ($donnee[0]["FIN"]) {
        $fin = "cette série est terminée.";
    } else {
        $fin = "cette série n'est pas terminée.";
    }

    $nom_serie = htmlspecialchars($donnee[0]["SERIE_NOM"]);
    $statut    = htmlspecialchars(strtolower($donnee[0]["STATUT_CODE"]));

    echo "<script src='../script/script.js' defer></script>";
    echo "<p>" . $nom_serie . " est un " . $statut . ".<br>J'ai $avancee le $media, $fin</p>";
    echo "<a href='../html/select.html'>Retour à la recherche</a>";
?>
