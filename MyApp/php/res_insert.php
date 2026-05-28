<?php

    include_once "pdo_agile.php";
    include_once "connexion.php";
    echo '<meta charset="utf-8"> ';

    $accueil = "../index.html";
    echo "<br><a href='" . $accueil . "'>Retour à l'accueil</a>";

    $insertion_page = "../html/insert.html";
    echo "<br><a href='" . $insertion_page . "'>Retour à l'ajout de série</a>";

    // Valeurs autorisées pour les champs radio (whitelist)
    $types_autorises   = ["MANGA", "ANIME", "MANWHA", "LN", "LIVE_ACTION"];
    $statuts_autorises = ["fini", "pasfini", "plustard"];

    if (!isset($_POST["nom"]) || !isset($_POST["type"]) || !isset($_POST["statut_moi"])) {
        echo "<h1>Il manque des champs obligatoires !</h1>";
    } else {

        // Validation et nettoyage des entrées
        $nom       = trim(strip_tags($_POST["nom"]));
        $type      = $_POST["type"];
        $fini      = $_POST["statut_moi"];
        $commentaire = isset($_POST["commentaire"]) ? trim(strip_tags($_POST["commentaire"])) : "";

        // Vérification par whitelist des champs radio
        if (!in_array($type, $types_autorises)) {
            echo "<h1>Type de série invalide.</h1>";
            exit;
        }
        if (!in_array($fini, $statuts_autorises)) {
            echo "<h1>Statut invalide.</h1>";
            exit;
        }
        if (empty($nom)) {
            echo "<h1>Le nom de la série ne peut pas être vide.</h1>";
            exit;
        }

        if (donnee_existe(CONN, $nom, $type)) {
            echo "<p>Cette série existe déjà</p>";
        } else {
            // Récupération du prochain code avec requête préparée
            $requete_indice = "SELECT max(serie_code) as serie_code FROM serie";
            LireDonneesPDO1(CONN, $requete_indice, $valeurs);
            $dernier = $valeurs[0]['serie_code'] + 1;

            // Calcul du statut
            if ($type == "ANIME") {
                if ($fini == "fini")      $statut = "ANIME_TERMINE";
                else if ($fini == "plustard") $statut = "PLUS_TARD_A";
                else                          $statut = "ANIME_EN_COURS";
            } else {
                if ($fini == "fini")      $statut = "LECTURE_TERMINEE";
                else if ($fini == "plustard") $statut = "PLUS_TARD_M";
                else                          $statut = "LECTURE_EN_COURS";
            }

            // INSERT principal avec requête préparée et paramètres liés
            $requete = "INSERT INTO serie (serie_code, serie_nom, statut_code, AVANCEE_CODE_AVANCEE) VALUES (:code, :nom, :type, :statut)";
            $cur = preparerRequetePDO(CONN, $requete);
            majDonneesPrepareesTabPDO($cur, [
                ':code'   => $dernier,
                ':nom'    => $nom,
                ':type'   => $type,
                ':statut' => $statut
            ]);

            // INSERT dans TEXTE si applicable
            if (!($type == "ANIME" || $type == "LIVE_ACTION")) {
                $requete_texte = "INSERT INTO TEXTE (serie_code) VALUES (:code)";
                $cur_texte = preparerRequetePDO(CONN, $requete_texte);
                majDonneesPrepareesTabPDO($cur_texte, [':code' => $dernier]);
            }

            // INSERT dans la table spécifique au type
            $code_col   = getcode($type);
            $dernier_type = dernierdutype($type);

            $requete_table_specifique = "INSERT INTO `$type` ($code_col, serie_code, nom) VALUES (:code_type, :serie_code, :nom)";
            $cur_type = preparerRequetePDO(CONN, $requete_table_specifique);
            majDonneesPrepareesTabPDO($cur_type, [
                ':code_type'  => $dernier_type,
                ':serie_code' => $dernier,
                ':nom'        => $nom
            ]);

            // UPDATE commentaire si renseigné
            if (!empty($commentaire)) {
                $modif_com = "UPDATE SERIE SET COMMENTAIRE = :commentaire WHERE serie_code = :code";
                $cur_com = preparerRequetePDO(CONN, $modif_com);
                majDonneesPrepareesTabPDO($cur_com, [
                    ':commentaire' => $commentaire,
                    ':code'        => $dernier
                ]);
            }

            echo "<p>C'est bon !</p>";
        }
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

    function donnee_existe($c, $nom, $type) {
        $sql = "SELECT * FROM serie WHERE serie_nom = :nom AND statut_code = :type";
        $cur = preparerRequetePDO($c, $sql);
        majDonneesPrepareesTabPDO($cur, [':nom' => $nom, ':type' => $type]);
        $tab = $cur->fetchAll(PDO::FETCH_ASSOC);
        return !empty($tab);
    }

?>
