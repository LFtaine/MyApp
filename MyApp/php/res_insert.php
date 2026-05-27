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
            echo "<p>Cette série existe déjà</p>";
        }
        else{
            $requete_indice="SELECT max(serie_code) as serie_code from serie";
            LireDonneesPDO1(CONN,$requete_indice,$valeurs);

            $dernier=$valeurs[0]['serie_code']+1;


            $nom=$_POST["nom"];
            $type=$_POST["type"];
            $fini=$_POST["statut_moi"];

            if($type=="ANIME" ){
                if($fini=="fini"){
                    $statut="ANIME_TERMINE";
                }
                else if($fini=="plustard"){
                    $statut="PLUS_TARD_A";
                }
                else{
                    $statut="ANIME_EN_COURS";
                }
            }
            else{
                if($fini=="fini"){
                    $statut="LECTURE_TERMINEE";
                }
                else if($fini=="plustard"){
                    $statut="PLUS_TARD_M";
                }
                else{
                    $statut="LECTURE_EN_COURS";
                }
            }
            $requete="INSERT INTO serie (serie_code,serie_nom,statut_code,AVANCEE_CODE_AVANCEE) values ($dernier,'$nom','$type','$statut')";
            majDonneesPrepareesPDO(preparerRequetePDO(CONN,$requete));

            if(!($type=="ANIME" || $type=="LIVE_ACTION")){
                $requete_texte="INSERT INTO TEXTE (serie_code) values (".$dernier.")";
                majDonneesPrepareesPDO(preparerRequetePDO(CONN,$requete_texte));
            }

            $requete_table_specifique="INSERT INTO ".$type.""." (".getcode($type).",serie_code,nom) values (".dernierdutype($type).",".$dernier.",'".$nom."')";
            majDonneesPrepareesPDO(preparerRequetePDO(CONN,$requete_table_specifique));

            echo "<p>C'est bon !</p>";
        }
       
    }

    function getcode($type){
        if($type=="LIVE_ACTION"){
        $code="LA_CODE";
        }
        else{
            $code="CODE_".$type;
        }
        return $code;
    }
       
    
    function dernierdutype($type){        
       
        $requete_indice="SELECT max(".getcode($type).") as serie_code from $type";
        LireDonneesPDO1(CONN,$requete_indice,$valeurs);
        
        $dernier=$valeurs[0]['serie_code']+1;
        return $dernier;
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