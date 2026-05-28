<?php

	include_once "pdo_agile.php";
	include_once "connexion.php";
	echo '<meta charset="utf-8"> ';


	if (CONN){
		
		echo "<a href=../index.html>Retour à l'accueil</a>";	
		
		$nom = $_POST["nom"];

		if (!empty($nom)) {
			lireDonneesTexte(CONN);
		}
	}
	else{
		echo ("<hr/> Connexion impossible à la base de données <br/>");
	}
		


	function lireDonneesTexte($c)
	{
		$texte=$_POST["nom"];
		$args="lower('%".$texte."%')";
		$sql = "select * from serie where lower(SERIE_NOM) like $args order by serie_nom";
		$cible="'details.php'";
		$code="SERIE_CODE";
	
		$res=LireDonneesPDO1($c,$sql,$donnee);

		if(empty($donnee)){
			echo "<br>Aucune série correspondante";
		}
		else{

		}
			foreach($donnee as $indice=> $l){

			if($l["STATUT_CODE"] == "MANGA"){
				$media="lire";
			}
			else{
				$media="regarder";
			}

			if($l["AVANCEE_CODE_AVANCEE"] == "ANIME_TERMINE" || $l["AVANCEE_CODE_AVANCEE"] == "LECTURE_TERMINEE" ){
				$avancee="finis de";
			}
			else{
				$avancee="commencé à";
			}

			if($l["FIN"]){
				$fin="cette série est terminée.";
			}
			else{
				$fin="cette série n'est pas terminée.";
			}

			$page = "details.php?num=" . $l[$code];

			echo "<p>La série s'appelle 
			<a href='$page'>".$l["SERIE_NOM"]."</a>
			c'est un ".strtolower($l["STATUT_CODE"])."
			et j'ai $avancee la $media, $fin</p>";
		}			


	
	
	
	}
	
	function afficherObj($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}
 ?>
