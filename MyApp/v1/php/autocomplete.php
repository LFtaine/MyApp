<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION["utilisateur_id"])) {
    echo json_encode([]);
    exit;
}

include_once "pdo_agile.php";
include_once "connexion.php";

$mode = isset($_GET["mode"]) ? $_GET["mode"] : "search";
$q    = isset($_GET["q"])    ? trim(strip_tags($_GET["q"])) : "";

if (empty($q) || !CONN) {
    echo json_encode([]);
    exit;
}

$utilisateur_id = $_SESSION["utilisateur_id"];
$results = [];

if ($mode === "search") {
    // Recherche dans les séries de l'utilisateur
    $sql = "SELECT s.SERIE_CODE, s.SERIE_NOM, s.STATUT_CODE, us.AVANCEE_CODE_AVANCEE
            FROM serie s
            INNER JOIN UTILISATEUR_SERIE us
                ON s.SERIE_CODE = us.SERIE_CODE
                AND us.UTILISATEUR_ID = :utilisateur_id
            WHERE lower(s.SERIE_NOM) LIKE lower(:search)
            ORDER BY s.SERIE_NOM
            LIMIT 8";
    $cur = preparerRequetePDO(CONN, $sql);
    majDonneesPrepareesTabPDO($cur, [
        ':utilisateur_id' => $utilisateur_id,
        ':search'         => '%' . $q . '%'
    ]);
    $rows = $cur->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $r) {
        $avancee = ($r["AVANCEE_CODE_AVANCEE"] === "ANIME_TERMINE" || $r["AVANCEE_CODE_AVANCEE"] === "LECTURE_TERMINEE")
            ? "✓ Terminé"
            : "En cours";
        $results[] = [
            "code"    => $r["SERIE_CODE"],
            "nom"     => $r["SERIE_NOM"],
            "type"    => strtolower($r["STATUT_CODE"]),
            "avancee" => $avancee
        ];
    }

} elseif ($mode === "insert") {
    // Recherche dans TOUTES les séries de la base (pour suggérer une existante)
    $sql = "SELECT s.SERIE_CODE, s.SERIE_NOM, s.STATUT_CODE,
                   IF(us.UTILISATEUR_ID IS NOT NULL, 1, 0) AS deja_dans_liste
            FROM serie s
            LEFT JOIN UTILISATEUR_SERIE us
                ON s.SERIE_CODE = us.SERIE_CODE
                AND us.UTILISATEUR_ID = :utilisateur_id
            WHERE lower(s.SERIE_NOM) LIKE lower(:search)
            ORDER BY s.SERIE_NOM
            LIMIT 8";
    $cur = preparerRequetePDO(CONN, $sql);
    majDonneesPrepareesTabPDO($cur, [
        ':utilisateur_id' => $utilisateur_id,
        ':search'         => '%' . $q . '%'
    ]);
    $rows = $cur->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $r) {
        $results[] = [
            "code"            => $r["SERIE_CODE"],
            "nom"             => $r["SERIE_NOM"],
            "type"            => strtolower($r["STATUT_CODE"]),
            "deja_dans_liste" => (bool)$r["deja_dans_liste"]
        ];
    }
}

echo json_encode($results);
