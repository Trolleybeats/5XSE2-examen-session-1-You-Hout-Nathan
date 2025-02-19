<?php
$expediteur= "Page Contact <forum@framework.be>";
$destinataire = "nathan.yh@hotmail.com";
$sujet = "Projet Framework - Formulaire de contact";

$entetes = [
    "From: " . $expediteur,
    "Reply-To: " . $_POST['email'],
    "MIME-Version: 1.0",
    "Content-Type: text/html; charset=UTF-8",
    "Content-Transfer-Encoding: quoted-printable"
];

$nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
$prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$message = nl2br(htmlspecialchars(trim($_POST['message'] ?? '')));

ob_start();
?>
<html>
    <body>
        <p>Nom = <?php echo $nom ?> </p>
        <p>Prénom = <?php echo $prenom ?> </p>
        <p>Mail = <?php echo $email ?> </p>
        <p>Message = <?php echo $message ?> </p>
    </body>
</html>
<?php
$message = ob_get_clean();
$message=quoted_printable_encode($message);

if (mail($destinataire, $sujet, $message,implode("\r\n", $entetes)))
{
    echo "Le courriel a été envoyé avec succès.";
}
else
{
    echo "L'envoi du courriel a échoué.";
}
?>