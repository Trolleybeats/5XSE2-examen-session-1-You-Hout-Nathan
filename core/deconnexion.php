<?php
require_once __DIR__ . '/gestionAuthentification.php';

deconnecter_utilisateur();

// Redirige vers la page de connexion avec un message
header("Location: ../connexion.php?deconnexion=1");
exit;

?>

