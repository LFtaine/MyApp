<?php session_start(); ?>
<?php
    include_once "pdo_agile.php";
    include_once "connexion.php";

    if (isset($_POST["login"]) && isset($_POST["mdp"])) {
        $sql = "SELECT UTILISATEUR_ID FROM UTILISATEUR WHERE LOGIN = :login AND MOT_DE_PASSE = :mdp";
        $cur = preparerRequetePDO(CONN, $sql);
        majDonneesPrepareesTabPDO($cur, [
            ':login' => $_POST["login"],
            ':mdp'   => $_POST["mdp"]
        ]);
        $user = $cur->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["login"] = $_POST["login"];
            $_SESSION["utilisateur_id"] = $user["UTILISATEUR_ID"];
            header("Location: ../index.php");
            exit;
        } else {
            $erreur = "Login ou mot de passe incorrect.";
        }
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" type="image/x-icon" href="../images/icone.ico">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

        <?php if (isset($erreur)): ?>
            <p class="error"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <form method="post">
            <input name="login" type="text" placeholder="Login">
            <input name="mdp" type="password" placeholder="Mot de passe">
            <button type="submit">Connexion</button>
        </form>
        <br>
        <a href="inscription.php">Je n'ai pas encore de compte</a>
    <a href="../index.php">Retour à l'accueil</a>
</body>
</html>
