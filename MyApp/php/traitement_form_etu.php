	<?php

	function afficherObj($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}

	include_once "pdo_agile.php";
	include_once "param_connexion_etu.php";
	echo '<meta charset="utf-8"> ';
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
	
			
	$erreur=false; 

	
	if ( $erreur == false )
	{	
	}
	else
		afficherObj("Le formulaire n'est pas complet");

	if (	$erreur == false )
	{
		
	}
	?>
