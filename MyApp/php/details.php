


        <?php
            include_once "pdo_agile.php";
            include_once "connexion.php";
            echo '<meta charset="utf-8"> ';
            
    
                

           $accueil="../index.html";
            echo "<br><a href='".$accueil."'>Retour à l'accueil</a>" ;
            
               // $sql = "select LAST_INSERT_ID from historique";
                
                $numero= $_GET['num'];
                $sql="select * from serie where serie_code = $numero";
                LireDonneesPDO1(CONN,$sql,$donnee);

                if($donnee[0]["STATUT_CODE"] == "MANGA"){
                    $media="lire";
                }
                else{
                    $media="regarder";
                }

                if($donnee[0]["AVANCEE_CODE_AVANCEE"] == "ANIME_TERMINE" || $donnee[0]["AVANCEE_CODE_AVANCEE"] == "LECTURE_TERMINEE" ){
                    $avancee="finis de";
                }
                else{
                    $avancee="commencé à";
                }

                if($donnee[0]["FIN"]){
                    $fin="cette série est terminée.";
                }
                else{
                    $fin="cette série n'est pas terminée.";
                }

                echo "<script src='../script/script.js' defer></script><p>".$donnee[0]["SERIE_NOM"] ." est un ".strtolower($donnee[0]["STATUT_CODE"]).".<br>
                J'ai $avancee le $media, $fin</p>" ;
                echo "<a href='../html/select.html'>Retour à la recherche </a>";
        ?>

