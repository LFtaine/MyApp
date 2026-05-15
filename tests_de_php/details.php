<html>
    <body>

        <?php
            include_once "pdo_agile.php";
            echo '<meta charset="utf-8"> ';
            
            
            $db_username = "root";
            $db_password = ""; //
            $db = "mysql:host=localhost;dbname=maliste;charset=UTF8";
            echo "test\n";
                
            $conn = OuvrirConnexionPDO($db,$db_username,$db_password); 
            echo "bleh";
            
               // $sql = "select LAST_INSERT_ID from historique";
                //LireDonneesPDO1($conn,$sql,$numero);
                $numero= $_GET['num'];

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

                echo "<p>la série s'appelle ".$donnee[0]["SERIE_NOM"]." c'est un ".strtolower($donnee[0]["STATUT_CODE"])." et j'ai $avancee la $media, $fin</p>" ;
        ?>
</body>
</html>