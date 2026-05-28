<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Modification</h1>
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
                $numero = $_GET['num'];
                $sql = "select * from serie where serie_code = $numero";

                $res = LireDonneesPDO1($c, $sql, $donnee);
                echo "<h2>Données déjà existantes:</h2>";

                foreach ($donnee as $indice => $l) {
                    foreach ($l as $propriete => $contenu) {
                        if (empty($l[$propriete])) {
                            echo "<br> $propriete : pas précisé";
                        } else {
                            echo "<br> $propriete : $contenu";
                        }
                    }
                }

                // Sélection du type de série
                if ($donnee[0]["STATUT_CODE"] == "MANGA") {
                    $genre_check = '
                        <input name="type" type="radio" id="manga_type" value="MANGA" required checked>
                        <label for="manga_type">Manga</label>
                        <input name="type" type="radio" id="anime_type" value="ANIME">
                        <label for="anime_type">Animé</label>
                        <input name="type" type="radio" id="manwha_type" value="MANWHA">
                        <label for="manwha_type">Manwha</label>
                        <input name="type" type="radio" id="ln_type" value="LN">
                        <label for="ln_type">Light novel</label>
                        <input name="type" type="radio" id="la_type" value="LIVE_ACTION">
                        <label for="la_type">Live action</label>';
                } else if ($donnee[0]["STATUT_CODE"] == "ANIME") {
                    $genre_check = '
                        <input name="type" type="radio" id="manga_type" value="MANGA" required>
                        <label for="manga_type">Manga</label>
                        <input name="type" type="radio" id="anime_type" value="ANIME" checked>
                        <label for="anime_type">Animé</label>
                        <input name="type" type="radio" id="manwha_type" value="MANWHA">
                        <label for="manwha_type">Manwha</label>
                        <input name="type" type="radio" id="ln_type" value="LN">
                        <label for="ln_type">Light novel</label>
                        <input name="type" type="radio" id="la_type" value="LIVE_ACTION">
                        <label for="la_type">Live action</label>';
                } else if ($donnee[0]["STATUT_CODE"] == "MANWHA") {
                    $genre_check = '
                        <input name="type" type="radio" id="manga_type" value="MANGA" required>
                        <label for="manga_type">Manga</label>
                        <input name="type" type="radio" id="anime_type" value="ANIME">
                        <label for="anime_type">Animé</label>
                        <input name="type" type="radio" id="manwha_type" value="MANWHA" checked>
                        <label for="manwha_type">Manwha</label>
                        <input name="type" type="radio" id="ln_type" value="LN">
                        <label for="ln_type">Light novel</label>
                        <input name="type" type="radio" id="la_type" value="LIVE_ACTION">
                        <label for="la_type">Live action</label>';
                } else if ($donnee[0]["STATUT_CODE"] == "LN") {
                    $genre_check = '
                        <input name="type" type="radio" id="manga_type" value="MANGA" required>
                        <label for="manga_type">Manga</label>
                        <input name="type" type="radio" id="anime_type" value="ANIME">
                        <label for="anime_type">Animé</label>
                        <input name="type" type="radio" id="manwha_type" value="MANWHA">
                        <label for="manwha_type">Manwha</label>
                        <input name="type" type="radio" id="ln_type" value="LN" checked>
                        <label for="ln_type">Light novel</label>
                        <input name="type" type="radio" id="la_type" value="LIVE_ACTION">
                        <label for="la_type">Live action</label>';
                } else {
                    $genre_check = '
                        <input name="type" type="radio" id="manga_type" value="MANGA" required>
                        <label for="manga_type">Manga</label>
                        <input name="type" type="radio" id="anime_type" value="ANIME">
                        <label for="anime_type">Animé</label>
                        <input name="type" type="radio" id="manwha_type" value="MANWHA">
                        <label for="manwha_type">Manwha</label>
                        <input name="type" type="radio" id="ln_type" value="LN">
                        <label for="ln_type">Light novel</label>
                        <input name="type" type="radio" id="la_type" value="LIVE_ACTION" checked>
                        <label for="la_type">Live action</label>';
                }

                // Sélection du statut de lecture
                if (
                    $donnee[0]["AVANCEE_CODE_AVANCEE"] == "LECTURE_EN_COURS" ||
                    $donnee[0]["AVANCEE_CODE_AVANCEE"] == "ANIME_EN_COURS"
                ) {
                    $type_check = '
                        <p>Où est ce que j\'en suis:</p>
                        <input name="statut_moi" id="jaifini" type="radio" value="fini" required>
                        <label for="jaifini">J\'ai terminé</label>
                        <input name="statut_moi" id="jaipasfini" type="radio" value="pasfini" checked>
                        <label for="jaipasfini">Je n\'ai pas terminé</label>
                        <input name="statut_moi" id="plustard" type="radio" value="plustard">
                        <label for="plustard">Pour plus tard</label>';
                } else if (
                    $donnee[0]["AVANCEE_CODE_AVANCEE"] == "LECTURE_TERMINEE" ||
                    $donnee[0]["AVANCEE_CODE_AVANCEE"] == "ANIME_TERMINE"
                ) {
                    $type_check = '
                        <p>Où est ce que j\'en suis:</p>
                        <input name="statut_moi" id="jaifini" type="radio" value="fini" required checked>
                        <label for="jaifini">J\'ai terminé</label>
                        <input name="statut_moi" id="jaipasfini" type="radio" value="pasfini">
                        <label for="jaipasfini">Je n\'ai pas terminé</label>
                        <input name="statut_moi" id="plustard" type="radio" value="plustard">
                        <label for="plustard">Pour plus tard</label>';
                } else {
                    $type_check = '
                        <p>Où est ce que j\'en suis:</p>
                        <input name="statut_moi" id="jaifini" type="radio" value="fini" required>
                        <label for="jaifini">J\'ai terminé</label>
                        <input name="statut_moi" id="jaipasfini" type="radio" value="pasfini">
                        <label for="jaipasfini">Je n\'ai pas terminé</label>
                        <input name="statut_moi" id="plustard" type="radio" value="plustard" checked>
                        <label for="plustard">Pour plus tard</label>';
                }

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