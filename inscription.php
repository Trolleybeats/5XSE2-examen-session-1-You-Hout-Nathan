<?php 
$pageTitre="Inscription";
$metaDescription="Vous êtes sur la page d'inscription";
require "header.php";
require_once (__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionBdd.php';
require (__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR .'traiter-formulaire.php';

try{
$pdo = obtenirConnexionBdd();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$erreurs, $valeurs] = traiterFormulaireInscription($_POST, $pdo);
}}catch (PDOException $e) {
    gererExceptions($e);
    return false;
} finally {
    // Libérer la connexion
    $pdo = null;
}
?>



<main>

<h1> Inscription </h1>

<form method="post">
<label for="inscription_pseudo">Votre pseudo :</label>
<input name="inscription_pseudo" id="inscription_pseudo" type="text" value="<?= $valeurs['pseudo'] ?? '' ?>" minlength="2" maxlength="255" required>
    <?php 
    if (isset($erreurs['pseudo'])) {
        echo $erreurs['pseudo'];
    }
    ?>

<label  for="inscription_email">Votre email :</label>
<input name="inscription_email" id="inscription_email" type="email" value="<?= $valeurs['email'] ?? '' ?>" required>
    <?php 
    if (isset($erreurs['email'])) {
        echo $erreurs['email'];
    }
    ?>

<label  for="inscription_motDePasse">Votre mot de passe :</label>
<input name="inscription_motDePasse" id="inscription_motDePasse" type="text" value=" " minlength="8" maxlength="72" required>
    <?php 
    if (isset($erreurs['motDePasse'])) {
        echo $erreurs['motDePasse'];
    }
    ?>

<label  for="inscription_motDePasse_confirmation">Confirmez votre mot de passe :</label>
<input name="inscription_motDePasse_confirmation" id="inscription_motDePasse_confirmation" type="text" value=" " minlength="8" maxlength="72" required>
    <?php 
    if (isset($erreurs['motDePasse'])) {
        echo $erreurs['motDePasse'];
    }
    ?>

<input type="submit" value="Envoyer">
</form>

<?php require "footer.php"?>