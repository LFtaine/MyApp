<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Modifications</h1>
        <?php
            include_once "pdo_agile.php";
            include_once "connexion.php";
            echo '<meta charset="utf-8"> ';

            if (CONN) {
                afficheDonnees(CONN);
            } else {
                echo ("<hr/> Connexion impossible à la base de données <br/>");
            }

            function afficheDonnees($c) {
                // Validation : $num doit être un entier
                $numero = isset($_GET['num']) ? intval($_GET['num']) : 0;
                if ($numero <= 0) {
                    echo "<p>Numéro de série invalide.</p>";
                    return;
                }

                $sql = "SELECT * FROM serie WHERE serie_code = :num";
                $cur = preparerRequetePDO($c, $sql);
                majDonneesPrepareesTabPDO($cur, [':num' => $numero]);
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

                // Sélection du type de série
                $types = ["MANGA", "ANIME", "MANWHA", "LN", "LIVE_ACTION"];
                $labels = [
                    "MANGA"       => "Manga",
                    "ANIME"       => "Animé",
                    "MANWHA"      => "Manwha",
                    "LN"          => "Light novel",
                    "LIVE_ACTION" => "Live action"
                ];
                $ids = [
                    "MANGA"       => "manga_type",
                    "ANIME"       => "anime_type",
                    "MANWHA"      => "manwha_type",
                    "LN"          => "ln_type",
                    "LIVE_ACTION" => "la_type"
                ];

                $genre_check = '';
                foreach ($types as $i => $t) {
                    $checked  = ($donnee[0]["STATUT_CODE"] == $t) ? " checked" : "";
                    $required = ($i === 0) ? " required" : "";
                    $genre_check .= '<input name="type" type="radio" id="' . $ids[$t] . '" value="' . $t . '"' . $required . $checked . '>
                        <label for="' . $ids[$t] . '">' . $labels[$t] . '</label>' . "\n";
                }

                // Sélection du statut de lecture
                $avancee = $donnee[0]["AVANCEE_CODE_AVANCEE"];
                $en_cours  = ($avancee == "LECTURE_EN_COURS"  || $avancee == "ANIME_EN_COURS");
                $termine   = ($avancee == "LECTURE_TERMINEE"  || $avancee == "ANIME_TERMINE");

                $type_check = '<p>Où est ce que j\'en suis:</p>
                    <input name="statut_moi" id="jaifini" type="radio" value="fini" required' . ($termine ? " checked" : "") . '>
                    <label for="jaifini">J\'ai terminé</label>
                    <input name="statut_moi" id="jaipasfini" type="radio" value="pasfini"' . ($en_cours ? " checked" : "") . '>
                    <label for="jaipasfini">Je n\'ai pas terminé</label>
                    <input name="statut_moi" id="plustard" type="radio" value="plustard"' . (!$en_cours && !$termine ? " checked" : "") . '>
                    <label for="plustard">Pour plus tard</label>';

                $formulaire = '
                    <form id="modif_form" method="POST">
                        <h3>Infos obligatoires:</h3>
                        <fieldset>
                            <input name="nom" type="text" placeholder="Nom de la série" value="' . htmlspecialchars($donnee[0]['SERIE_NOM']) . '">
                            <p>Type de série:</p>
                            ' . $genre_check . '
                            ' . $type_check . '
                        </fieldset>
                        <h3>Infos bonus</h3>
                        <fieldset>
                            <input name="commentaire" type="text" placeholder="Laissez un commentaire" value="' . htmlspecialchars($donnee[0]['COMMENTAIRE']) . '">
                        </fieldset>
                        <input type="hidden" name="num" value="' . $numero . '">
                        <button type="submit">Valider</button>
                    </form>';
                echo $formulaire;
            }

            function afficherObj($donnee) {
                echo "<PRE>";
                print_r($donnee);
                echo "</PRE>";
            }
        ?>

        <a href="../index.html">Retour à l'accueil</a>
    </body>
</html>
