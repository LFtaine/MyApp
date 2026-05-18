<?php

    include_once "pdo_agile.php";
    include_once "connexion.php";
    echo '<meta charset="utf-8"> ';
 
     
    $accueil="../index.html";
    echo "<br><a href='".$accueil."'>Retour à l'accueil</a>" ;

    $insertion_page="../html/insert.html";
    echo "<br><a href='".$insertion_page."'>Retour à l'ajout de série</a>" ;

    if( ! isset($_POST["nom"]) || ! isset($_POST["type"]) || ! isset($_POST["statut_moi"])){
         echo "<h1>Il manque des champs obligatoires !</h1>";
    }
    else{
        if (donnee_existe(CONN,$_POST["nom"],$_POST["type"])){
            echo "Cette série existe déjà";
        }
        else{
            $requete_indice="SELECT max(serie_code) as serie_code from serie";
            LireDonneesPDO1(CONN,$requete_indice,$valeurs);

            $dernier=$valeurs[0]['serie_code']+1;


            $nom=$_POST["nom"];
            $type=$_POST["type"];
            $requete="INSERT INTO serie (serie_code,serie_nom,statut_code,AVANCEE_CODE_AVANCEE) values ($dernier,'$nom','$type','LECTURE_TERMINEE')";
            majDonneesPrepareesPDO(preparerRequetePDO(CONN,$requete));
            echo "cest bon !";
        }
       
    }
       
    

    function donnee_existe($c,$nom,$type){
        
        $sql = "SELECT * FROM serie WHERE serie_nom = '$nom' AND statut_code = '$type'";

        LireDonneesPDO1($c,$sql,$donnees);
        if(empty($donnees)){
            return false;
        }
        else{
            return true;
        }
        
        
    }


    


?>