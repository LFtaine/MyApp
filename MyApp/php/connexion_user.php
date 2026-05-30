
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
            $_SESSION["utilisateur_id"] = $user["UTILISATEUR_ID"]; // ← l'ID numérique
            header("Location: ../index.html");
        } else {
            echo "Login ou mot de passe incorrect.";
        }
    } else {
        echo "Veuillez remplir les deux champs";
    }
?>
<html>

<body>
    <h1>Connexion</h1>
    <a href="inscription.html">Je n'ai pas encore de compte</a>

    <form method="post">
        <input name="login" type="text" placeholder="Login">
        <input name="mdp" type="password" placeholder="Mot de passe">
        <button type="submit">Connexion</button>

    </form>

</body>


</html>








