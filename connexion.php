<?php 
$pageTitre="Connexion";
$metaDescription="Vous êtes sur la page de connexion";
require "header.php";
require_once (__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionBdd.php';

$pdo = obtenirConnexionBdd();

$message = "";
$pseudo = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pseudo = trim($_POST['connexion_pseudo'] ?? '');
    $motDePasse = trim($_POST['connexion_motDePasse'] ?? '');

    if ($pseudo === '' || $motDePasse === '') {
        $message = "<p style='color:red;'>Tous les champs sont obligatoires.</p>";
    } else {
        $stmt = $pdo->prepare("SELECT uti_motdepasse FROM t_utilisateur_uti WHERE uti_pseudo = ?");
        $stmt->execute([$pseudo]);
        $utilisateur = $stmt->fetch();

        if ($utilisateur && password_verify($motDePasse, $utilisateur['uti_motdepasse'])) {
            $message = "<p style='color:green;'>Connexion réussie ! Bienvenue, $pseudo.</p>";
        } else {
            $message = "<p style='color:red;'>Identifiants incorrects. Veuillez réessayer.</p>";
        }
    }
}
?>

<main>

<h1> Connexion </h1>

<?= $message ?>

<form method="post">
<label for="connexion_pseudo">Votre pseudo :</label>
<input name="connexion_pseudo" id="connexion_pseudo" type="text" value="<?= htmlspecialchars($pseudo) ?>" minlength="2" maxlength="255" required>

<label  for="connexion_motDePasse">Votre mot de passe :</label>
<input name="connexion_motDePasse" id="connexion_motDePasse" type="text" value=" " minlength="8" maxlength="72" required>

<input type="submit" value="Envoyer">
</form>

<p><a href="inscription.php">Inscrivez-vous</a></p>

<?php require "footer.php"?>