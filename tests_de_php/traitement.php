<?php
	// XXX : Saison 5 , Épisode 3 
	// préparation SAE 2.456 : programme principal
	// connexion_oracle_etu.php 29/05/2021
	
	include_once "pdo_agile.php";
	echo '<meta charset="utf-8"> ';
	// décommenter en fonction du serveur de BDD utilisé
	
	
	$db_username = "root";
	$db_password = ""; //
	$db = "mysql:host=localhost;dbname=maliste;charset=UTF8";
	echo "test\n";
		
	$conn = OuvrirConnexionPDO($db,$db_username,$db_password); // à compléter

	if ($conn)
	{
		echo ("<hr/> Connexion réussie à la base de données <br/>");
		//insererDonnee($conn); //fonctionnel mais ne pas en abuser pour éviter les erreurs
		//corrigerDonnees($conn);
		$table = lireDonnees($conn);
		afficherObj($table);
	}
	else
		echo ("<hr/> Connexion impossible à la base de données <br/>");
	
	function insererDonnee($c)
	{
		$sql = "INSERT INTO serie (SERIE_CODE, SERIE_NOM, AVANCEE_CODE_AVANCEE,STATUT_CODE) VALUES (1902,'serie_test','ANIME_TERMINE','MANGA')";
		afficherObj($sql);
		$sql_preparee=preparerRequetePDO($c,$sql);
		$res = majDonneesPrepareesPDO($sql_preparee);
		echo "Résultats de la requête " ,$res . "<br/>";
	}
	
	function corrigerDonnees($c)
	{
		$sql = "update bidon set ...'";
		afficherObj($sql);
		//$res = // compléter
		echo "Résultats de la requête " . $res . "<br/>";
	}

	function lireDonnees($c)
	{
		$numero=$_POST["index"];
		$sql = "select * from serie where serie_code = $numero";
		LireDonneesPDO1($c,$sql,$donnee);

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

		echo "la série s'appelle ".$donnee[0]["SERIE_NOM"]." c'est un ".strtolower($donnee[0]["STATUT_CODE"])." et j'ai $avancee la $media, $fin" ;
		return $donnee;
	}
	
	function afficherObj($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}
 ?>
