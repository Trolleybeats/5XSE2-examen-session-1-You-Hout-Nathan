<?php

require 'traiter-formulaire.php';

$erreurs = []; 
$valeursEchappees = [];
$message = $messageErreur = "";
$formSoumis = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formSoumis = true;
    list($erreurs, $valeursEchappees) = traiterFormulaire($_POST);
}

if (empty($erreurs)) {
    $message = "Formulaire soumis avec succès!";
}
else{
    $messageErreur="Echec d'envoi du formulaire";
}

$pageTitre="Contact";
$metaDescription="Vous êtes sur la page de contact";
require "header.php";
?>

<main>

<h1>Contact</h1>

<p><form method="post">
<label for="nom">Votre nom :</label>
<input name="nom" id="nom" type="text"  minlength="2" maxlength="255" value="<?= $valeursEchappees['nom'] ?? '' ?>" minlength="2" maxlength="50" required>
    <?php 
    if (isset($erreurs['nom'])) {
        echo $erreurs['nom'];
    }
    ?>

<label for="prenom">Votre prénom :</label>
<input name="prenom" id="prenom" type="text" value=" " maxlength="255">

<label  for="email">Votre email :</label>
<input name="email" id="email" type="email" value="<?= $valeursEchappees['email'] ?? '' ?>" required>
    <?php 
    if (isset($erreurs['email'])) {
        echo $erreurs['email'];
    }
    ?>

<label for="message">Message :</label>
<textarea name="message" id="message"  minlength="10" maxlength="3000" required><?= $valeursEchappees['message'] ?? '' ?></textarea>
    <?php 
    if (isset($erreurs['message'])) {
        echo $erreurs['message'];
    }
    ?>

</p>

<input type="submit" value="Envoyer">
</form>


<?php
if ($formSoumis) {
    if (!empty($message)) {
        echo "<p>" . $message . "</p>";
        require_once "mail.php";
    } else {
        echo "<p>" . $messageErreur . "</p>";
    }
}

require "footer.php"
?>