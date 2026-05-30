<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/style.css">
    <title>Accueil</title>
</head>
<body>
    <?php if (isset($_SESSION["utilisateur_id"])): ?>
        <h1>Bienvenue <?= htmlspecialchars($_SESSION["login"]) ?></h1>
        <div class="nav">
            <a href="html/select.html">Rechercher</a>
            <a href="html/insert.html">Ajouter une série</a>
            <a href="html/modif.html">Modifier une série</a>
            <a href="php/deconnexion.php">Se déconnecter</a>
        </div>
        
    

    <?php else: ?>
        <h1>Bienvenue</h1>
        <a href="php/connexion_user.php">Connexion</a>
    <?php endif; ?>
    
    
</body>
</html>