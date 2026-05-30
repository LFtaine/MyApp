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
    <title>Insertion</title>
</head>
<body>
    <a href="../index.php">Retour à l'accueil</a>
    <br>
    <a href="../html/insert.html">Retour à l'ajout de série</a>

    <?php
    $types_autorises   = ["MANGA", "ANIME", "MANWHA", "LN", "LIVE_ACTION"];
    $statuts_autorises = ["fini", "pasfini", "plustard"];

    if (!isset($_POST["nom"]) || !isset($_POST["type"]) || !isset($_POST["statut_moi"])) {
        echo "<p>Il manque des champs obligatoires !</p>";
    } else {
        $nom         = trim(strip_tags($_POST["nom"]));
        $type        = $_POST["type"];
        $fini        = $_POST["statut_moi"];
        $commentaire = isset($_POST["commentaire"]) ? trim(strip_tags($_POST["commentaire"])) : "";

        if (!in_array($type, $types_autorises)) {
            echo "<p>Type de série invalide.</p>";
            exit;
        }
        if (!in_array($fini, $statuts_autorises)) {
            echo "<p>Statut invalide.</p>";
            exit;
        }
        if (empty($nom)) {
            echo "<p>Le nom de la série ne peut pas être vide.</p>";
            exit;
        }

        if ($type == "ANIME") {
            if ($fini == "fini")          $statut = "ANIME_TERMINE";
            else if ($fini == "plustard") $statut = "PLUS_TARD_A";
            else                          $statut = "ANIME_EN_COURS";
        } else {
            if ($fini == "fini")          $statut = "LECTURE_TERMINEE";
            else if ($fini == "plustard") $statut = "PLUS_TARD_M";
            else                          $statut = "LECTURE_EN_COURS";
        }

        $serie_code = serie_existe_en_base(CONN, $nom, $type);

        if ($serie_code === false) {
            $requete = "INSERT INTO serie (serie_nom, statut_code) VALUES (:nom, :type)";
            $cur = preparerRequetePDO(CONN, $requete);
            majDonneesPrepareesTabPDO($cur, [':nom' => $nom, ':type' => $type]);

            $serie_code = (int) CONN->lastInsertId();

            if (!($type == "ANIME" || $type == "LIVE_ACTION")) {
                $requete_texte = "INSERT INTO TEXTE (serie_code) VALUES (:code)";
                $cur_texte = preparerRequetePDO(CONN, $requete_texte);
                majDonneesPrepareesTabPDO($cur_texte, [':code' => $serie_code]);
            }

            $code_col     = getcode($type);
            $dernier_type = dernierdutype($type);

            $requete_type = "INSERT INTO `$type` ($code_col, serie_code, nom) VALUES (:code_type, :serie_code, :nom)";
            $cur_type = preparerRequetePDO(CONN, $requete_type);
            majDonneesPrepareesTabPDO($cur_type, [
                ':code_type'  => $dernier_type,
                ':serie_code' => $serie_code,
                ':nom'        => $nom
            ]);

            echo "<p>Nouvelle série créée en base.</p>";
        } else {
            if (user_a_deja_serie(CONN, $utilisateur_id, $serie_code)) {
                echo "<p>Cette série est déjà dans votre liste !</p>";
                exit;
            }
            echo "<p>Série déjà connue en base, ajout à votre liste.</p>";
        }

        $requete_us = "INSERT INTO UTILISATEUR_SERIE (UTILISATEUR_ID, SERIE_CODE, AVANCEE_CODE_AVANCEE, COMMENTAIRE)
                       VALUES (:user_id, :serie_code, :avancee, :commentaire)";
        $cur_us = preparerRequetePDO(CONN, $requete_us);
        majDonneesPrepareesTabPDO($cur_us, [
            ':user_id'     => $utilisateur_id,
            ':serie_code'  => $serie_code,
            ':avancee'     => $statut,
            ':commentaire' => !empty($commentaire) ? $commentaire : null
        ]);

        echo "<p>C'est bon, série ajoutée à votre liste !</p>";
    }

    function serie_existe_en_base($c, $nom, $type) {
        $sql = "SELECT serie_code FROM serie WHERE serie_nom = :nom AND statut_code = :type";
        $cur = preparerRequetePDO($c, $sql);
        majDonneesPrepareesTabPDO($cur, [':nom' => $nom, ':type' => $type]);
        $tab = $cur->fetchAll(PDO::FETCH_ASSOC);
        return empty($tab) ? false : (int)$tab[0]['serie_code'];
    }

    function user_a_deja_serie($c, $user_id, $serie_code) {
        $sql = "SELECT 1 FROM UTILISATEUR_SERIE WHERE UTILISATEUR_ID = :user_id AND SERIE_CODE = :serie_code";
        $cur = preparerRequetePDO($c, $sql);
        majDonneesPrepareesTabPDO($cur, [':user_id' => $user_id, ':serie_code' => $serie_code]);
        return !empty($cur->fetchAll(PDO::FETCH_ASSOC));
    }

    function getcode($type) {
        return ($type == "LIVE_ACTION") ? "LA_CODE" : "CODE_" . $type;
    }

    function dernierdutype($type) {
        $code_col = getcode($type);
        $requete_indice = "SELECT max(`$code_col`) as serie_code FROM `$type`";
        LireDonneesPDO1(CONN, $requete_indice, $valeurs);
        return $valeurs[0]['serie_code'] + 1;
    }
    ?>
</body>
</html>
