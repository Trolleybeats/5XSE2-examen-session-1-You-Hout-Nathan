<?php 
$pageTitre="Contact";
$metaDescription="Vous êtes sur la page de contact";
require "header.php"?>

<h1>Contact</h1>

<p><form action=" " method="post">
<label class="required" for="nom">Votre nom :</label>
<input name="nom" id="nom" type="text"  minlength="2" maxlength="255" required />

<label for="prenom">Votre prénom :</label>
<input name="prenom" id="prenom" type="text" minlength="2" maxlength="255" />

<label class="required"  for="email">Votre email :</label>
<input name="email" id="email" type="email" required />

<label class="required" for="message">Message :</label>
<textarea name="message" id="message"  minlength="10" maxlength="3000" required></textarea>

</p>

<input type="submit" value="Envoyer">
</form>


<?php require "footer.php"?>