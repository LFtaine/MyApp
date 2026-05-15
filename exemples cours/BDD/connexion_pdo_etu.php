<?php
	// XXX : Saison 5 , Épisode 3 
	// préparation SAE 2.456 : programme principal
	// connexion_oracle_etu.php 29/05/2021
	
	include_once "pdo_agile.php";
	echo '<meta charset="utf-8"> ';
	// décommenter en fonction du serveur de BDD utilisé
	
	
	$db_username = "root";
	$db_password = ""; //
	$db = "mysql:host=localhost;dbname=liste;charset=UTF8";
		
	$conn = OuvrirConnexionPDO(); // à compléter

	if ($conn)
	{
		echo ("<hr/> Connexion réussie à la base de données <br/>");
		//insererDonnee($conn);
		//corrigerDonnees($conn);
		//$table = lireDonnees($conn);
	}
	else
		echo ("<hr/> Connexion impossible à la base de données <br/>");
	
	function insererDonnee($c)
	{
		$sql = "INSERT INTO bidon VALUES (25,'Valise','jaune')";
		afficherObj($sql);
		//$res = // compléter
		echo "Résultats de la requête " ,$res . "<br/>";
		$sql = "INSERT INTO bidon ...)";
		//$res = // compléter
		echo "Résultats de la requête ",$res . "<br/>";
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
		$sql = "select * from bidon";
		// compléter
		return $donnee;
	}
	
	function afficherObj($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}
 ?>
