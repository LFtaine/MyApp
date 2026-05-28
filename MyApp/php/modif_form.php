<html>
    <head>
        <meta charset="utf-8">
    </head>

<body>
    <h1>Modification</h1>
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






		
		
	}
	
	    function afficherObj($donnee)
	    {
		    echo "<PRE>";
		print_r($donnee);
		echo "</PRE>";
	    }
    ?>

 <form id="modif_form" method="POST">
	<fieldset>
    <input name="nom" type="text" placeholder="Nom de la série">	
</fieldset>

</form>

    



    <a href="../index.html">Retour à l'accueil</a>


</body>


</html>