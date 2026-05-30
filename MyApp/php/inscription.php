<?php session_start(); ?>

<?php
    include_once "pdo_agile.php";
    include_once "connexion.php";

    if (isset($_POST["login"]) && isset($_POST["mdp"])) {

        // Vérifier si le login existe déjà
        $sql = "SELECT UTILISATEUR_ID FROM UTILISATEUR WHERE LOGIN = :login";
        $cur = preparerRequetePDO(CONN, $sql);
        majDonneesPrepareesTabPDO($cur, [':login' => $_POST["login"]]);
        $existant = $cur->fetch(PDO::FETCH_ASSOC);

        if ($existant) {
            $erreur = "Ce login est déjà pris, choisissez-en un autre.";
        } else {
            // Insérer le nouvel utilisateur
            $sql = "INSERT INTO UTILISATEUR (LOGIN, MOT_DE_PASSE) VALUES (:login, :mdp)";
            $cur = preparerRequetePDO(CONN, $sql);
            majDonneesPrepareesTabPDO($cur, [
                ':login' => $_POST["login"],
                ':mdp'   => $_POST["mdp"]
            ]);

            // Auto-login si la case est cochée
            if (isset($_POST["autologin"])) {
                $id = CONN->lastInsertId();
                $_SESSION["login"] = $_POST["login"];
                $_SESSION["utilisateur_id"] = $id;
            }

            header("Location: ../index.html");
            exit;
        }
    }
?>

<html>
<body>
    <a href="../index.html">Retour à l'accueil</a>
    <a href="connexion_user.php">Retour à la page de connexion</a>
    <h1>Inscription</h1>

    <?php if (isset($erreur)): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post">
        <input name="login" type="text" placeholder="Identifiant">
        <input name="mdp" type="password" placeholder="Mot de passe">
        <br>
        <input type="checkbox" name="autologin" id="autologin">
        <label for="autologin">Me connecter automatiquement</label>
        <br>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>