<h1>Confirmation</h1>
<?php

	include_once "pdo_agile.php";
	include_once "connexion.php";
	echo '<meta charset="utf-8"> ';
	
	if (CONN){
		
		afficheDonnees(CONN);
	}
	else{
		echo ("<hr/> Connexion impossible à la base de données <br/>");
	}



	function afficheDonnees($c)
	{
		$numero= $_GET['num'];
		$sql="select * from serie where serie_code = $numero";
			
		$res=LireDonneesPDO1($c,$sql,$donnee);
		echo "<h2>Données déjà existantes:</h2>";
		
		foreach($donnee as $indice=> $l){
			foreach($l as $propriete=> $contenu){
				if(empty($l[$propriete])){
					echo "<br> $propriete : pas précisé";
				}
				else{
					echo "<br> $propriete : $contenu";
				}
			}

		}
		$button_ok= "<br><a href='modif_form.php?num=".$numero."'><button>C'est bien celle que je veux</button></a>";
		echo $button_ok;

		$button_non= "<br><a href='../html/modif.html'><button>C'est pas la bonne</button></a>";
		echo $button_non;

		
		
	}
	
	function afficherObj($donnee)
	{
		echo "<PRE>";
		print_r($donnee);
		echo "</PRE>";
	}
 ?>






