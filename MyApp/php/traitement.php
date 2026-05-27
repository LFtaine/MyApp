<?php

	include_once "pdo_agile.php";
	include_once "connexion.php";
	echo '<meta charset="utf-8"> ';


	if (CONN){
		
		echo "<a href=../index.html>Retour à l'accueil</a>";	
		
		$nom = $_POST["nom"] ?? null;

		if (!empty($nom)) {
			lireDonneesTexte(CONN);
		}
	}
	else
		echo ("<hr/> Connexion impossible à la base de données <br/>");
	
	function insererDonnee($c){
		$sql = "INSERT INTO serie (SERIE_CODE, SERIE_NOM, AVANCEE_CODE_AVANCEE,STATUT_CODE) VALUES (1902,'serie_test','ANIME_TERMINE','MANGA')";
		afficherObj($sql);
		$sql_preparee=preparerRequetePDO($c,$sql);
		$res = majDonneesPrepareesPDO($sql_preparee);
		echo "Résultats de la requête " ,$res . "<br/>";
	}
	
	function corrigerDonnees($c){
		$sql = "update bidon set ...'";
		afficherObj($sql);
		echo "Résultats de la requête " . $res . "<br/>";
	}


	

	function update_historique($c,$prev){
		$sql = "INSERT INTO historique (SERIE_CODE) VALUES ($prev)";
		$sql_preparee=preparerRequetePDO($c,$sql);
		$res = majDonneesPrepareesPDO($sql_preparee);
		echo "Résultats de la requête " ,$res . "<br/>";
	}

	function lireDonneesTexte($c)
	{
		$texte=$_POST["nom"];
		$args="lower('%".$texte."%')";
		$sql = "select * from serie where lower(SERIE_NOM) like $args";
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


		
		
			return $donnee;
	}
	
	function afficherObj($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}
 ?>
