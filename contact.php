<?php 
$pageTitre="Contact";
$metaDescription="Vous êtes sur la page de contact";
require "header.php";

require 'traiter-formulaire.php';

$erreurs = []; 
$valeursEchappees = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    list($erreurs, $valeursEchappees) = traiterFormulaire($_POST);
}

if (empty($erreurs)) {
    $message = "Formulaire soumis avec succès!";
}
else{
    $messageErreur="Echec d'envoi du formulaire";
}

if (isset($message)) {
    echo "<p>" . $message . "</p>";
}
else{
    echo "<p>" . $messageErreur . "</p>";
}
?>



<h1>Contact</h1>

<p><form method="post">
<label class="required" for="nom">Votre nom :</label>
<input name="nom" id="nom" type="text"  minlength="2" maxlength="255" value="<?= $valeursEchappees['nom'] ?? '' ?>" minlength="2" maxlength="50" required>
    <?php 
    if (isset($erreurs['nom'])) {
        echo $erreurs['nom'];
    }
    ?>

<label for="prenom">Votre prénom :</label>
<input name="prenom" id="prenom" type="text" value="<?= $valeursEchappees['prenom'] ?? '' ?>" minlength="2" maxlength="255">
    <?php 
    if (isset($erreurs['prenom'])) {
        echo $erreurs['prenom'];
    }
    ?>

<label class="required"  for="email">Votre email :</label>
<input name="email" id="email" type="email" value="<?= $valeursEchappees['email'] ?? '' ?>" required>
    <?php 
    if (isset($erreurs['email'])) {
        echo $erreurs['email'];
    }
    ?>

<label class="required" for="message">Message :</label>
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
require "footer.php"
?>