<?php
session_start();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['utilisateurId'])) {
    header('Location: connexion.php');
    exit;
}

require_once "core/gestionBdd.php";
require_once "core/gestionErreur.php";

$pageTitre = "Profil";
$metaDescription = "Page de profil utilisateur";
require "header.php";

try {
    $pdo = obtenirConnexionBdd();
    $id = $_SESSION['utilisateurId'];

    // Requête pour récupérer les infos de l'utilisateur connecté
    $stmt = $pdo->prepare("SELECT uti_pseudo, uti_email FROM t_utilisateur_uti WHERE uti_id = ?");
    $stmt->execute([$id]);
    $utilisateur = $stmt->fetch();
} catch (PDOException $e) {
    gererExceptions($e);
} finally {
    $pdo = null;
}?>

<h1>Profil</h1>

<p><strong>Pseudo :</strong> <?= htmlspecialchars($utilisateur['uti_pseudo']) ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['uti_email']) ?></p>

<form method="post" action="core/deconnexion.php">
    <button type="submit">Déconnexion</button>
</form>

<?php require "footer.php"; ?>
