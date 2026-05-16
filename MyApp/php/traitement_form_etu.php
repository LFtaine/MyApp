	<?php
	// E.Porcq : Saison 5 , Épisode 3 
	// préparation SAE 2.456 : Traitement d'un formualaire
	// traitement_form_etu.php 29/05/2021

	function afficherObj($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}

	include_once "pdo_agile.php";
	include_once "param_connexion_etu.php";
	echo '<meta charset="utf-8"> ';
	//define ("MOD_BDD","MYSQL");
	define ("MOD_BDD","ORACLE");

	if (MOD_BDD == "MYSQL")
	{
		$db_username = $db_usernameMySQL;		
		$db_password = $db_passwordMySQL;
		$db = $dbMySQL;
	}
	else
	{
		$db_username = $db_usernameOracle;		
		$db_password = $db_passwordOracle;	
		$db = $dbOracle;
	}

	$conn = OuvrirConnexionPDO($db,$db_username,$db_password);
	
	// affichage brut des éléments du formulaire
	// placer le code ici
			
	$erreur=false; // true => formulaire défaut

	/*
	// il faut vérifier que ces données ont été saisies
	$nom = 
	$prenom = 
	$code = 
	$genre =
	$pays = 
	$preference =
	$gouts = $_POST["gouts"]; 
	*/
	
	if ( $erreur == false )
	{	
		/*
		$sql = "INSERT INTO personne (per_nom, per_prenom, per_mdp, per_genre, per_pays, per_gouts_autres   )
		VALUES ('$nom','".$prenom."','".$code."','".$genre."','".$pays."','".$gouts."')";
		afficherObj($sql);
		$res = majDonneesPDO($conn,$sql);
		echo "Résultats de la requête ",$res . "<br/>";
		afficherObj($res);
		*/
	}
	else
		afficherObj("Le formulaire n'est pas complet");

	// partie 2
	if (	$erreur == false )
	{
		
	}
	?>
