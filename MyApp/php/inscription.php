<?php session_start(); ?>
<?php
    include_once "pdo_agile.php";
    include_once "connexion.php";

    if (isset($_POST["login"]) && isset($_POST["mdp"])) {
        $sql = "SELECT UTILISATEUR_ID FROM UTILISATEUR WHERE LOGIN = :login";
        $cur = preparerRequetePDO(CONN, $sql);
        majDonneesPrepareesTabPDO($cur, [':login' => $_POST["login"]]);
        $existant = $cur->fetch(PDO::FETCH_ASSOC);

        if ($existant) {
            $erreur = "Ce login est déjà pris, choisissez-en un autre.";
        } else {
            $sql = "INSERT INTO UTILISATEUR (LOGIN, MOT_DE_PASSE) VALUES (:login, :mdp)";
            $cur = preparerRequetePDO(CONN, $sql);
            majDonneesPrepareesTabPDO($cur, [
                ':login' => $_POST["login"],
                ':mdp'   => $_POST["mdp"]
            ]);

            if (isset($_POST["autologin"])) {
                $id = CONN->lastInsertId();
                $_SESSION["login"] = $_POST["login"];
                $_SESSION["utilisateur_id"] = $id;
            }

            header("Location: ../index.php");
            exit;
        }
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h1>Inscription</h1>

    <?php if (isset($erreur)): ?>
        <p class="error"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post">
        <input name="login" type="text" placeholder="Identifiant">
        <input name="mdp" type="password" placeholder="Mot de passe">
        <div>
            <input type="checkbox" name="autologin" id="autologin">
            <label for="autologin">Me connecter automatiquement</label>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
    <br>
    <a href="connexion_user.php">Retour à la page de connexion</a>
    <a href="../index.php">Retour à l'accueil</a>
</body>
</html>
