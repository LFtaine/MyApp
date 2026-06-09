<?php session_start(); ?>
<?php
    include_once "pdo_agile.php";
    include_once "connexion.php";

    $erreur = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $login = trim($_POST["login"] ?? "");
        $mdp   = $_POST["mdp"] ?? "";
        $mdp2  = $_POST["mdp2"] ?? "";

        if (empty($login)) {
            $erreur = "Veuillez choisir un identifiant.";
        } elseif (strlen($login) < 3) {
            $erreur = "L'identifiant doit faire au moins 3 caractères.";
        } elseif (empty($mdp)) {
            $erreur = "Veuillez choisir un mot de passe.";
        } elseif (strlen($mdp) < 4) {
            $erreur = "Le mot de passe doit faire au moins 4 caractères.";
        } elseif ($mdp !== $mdp2) {
            $erreur = "Les deux mots de passe ne correspondent pas.";
        } else {
            // Vérifier si le login est déjà pris
            $sql = "SELECT UTILISATEUR_ID FROM UTILISATEUR WHERE LOGIN = :login";
            $cur = preparerRequetePDO(CONN, $sql);
            majDonneesPrepareesTabPDO($cur, [':login' => $login]);
            $existant = $cur->fetch(PDO::FETCH_ASSOC);

            if ($existant) {
                $erreur = "Ce login est déjà pris, choisissez-en un autre.";
            } else {
                $sql = "INSERT INTO UTILISATEUR (LOGIN, MOT_DE_PASSE) VALUES (:login, :mdp)";
                $cur = preparerRequetePDO(CONN, $sql);
                majDonneesPrepareesTabPDO($cur, [
                    ':login' => $login,
                    ':mdp'   => $mdp
                ]);

                if (isset($_POST["autologin"])) {
                    $id = CONN->lastInsertId();
                    $_SESSION["login"]          = $login;
                    $_SESSION["utilisateur_id"] = $id;
                }

                header("Location: ../index.php");
                exit;
            }
        }
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" type="image/x-icon" href="../images/icone.ico">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php if ($erreur !== ""): ?>
        <p class="error"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post" novalidate>
        <input name="login" type="text" placeholder="Identifiant (min. 3 caractères)"
               value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" required>
        <input name="mdp" type="password" placeholder="Mot de passe (min. 4 caractères)" required>
        <input name="mdp2" type="password" placeholder="Confirmer le mot de passe" required>
        <div>
            <input type="checkbox" name="autologin" id="autologin"
                   <?= isset($_POST['autologin']) ? 'checked' : '' ?>>
            <label for="autologin">Me connecter automatiquement</label>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
    <br>
    <a href="connexion_user.php">Retour à la page de connexion</a>
    <br>
    <a href="../index.php">Retour à l'accueil</a>
</body>
</html>
