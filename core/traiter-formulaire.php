<?php
function traiterFormulaire($post) {
    $erreurs = [];
    $valeursEchappees = [];


    $nom = trim($post['nom'] ?? '');
    $prenom = trim($post['prenom'] ?? '');
    $email = trim($post['email'] ?? '');
    $message = trim($post['message'] ?? '');

    try{
    if ($nom == '') {
        $erreurs['nom'] = "<p>Le nom est requis!</p>";
    } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 50) {
        $erreurs['nom'] = "<p>Le nom doit contenir entre 2 et 50 caractères!</p>";
    };

    if ($email == '') {
        $erreurs['email'] = "<p>Le mail est requis!</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = "<p>Veuillez saisir une adresse email valide !</p>";
    };

    if ($message == '') {
        $erreurs['message'] = "<p>Le message est requis!</p>";
    } elseif (mb_strlen($message) < 10 || mb_strlen($message) > 3000) {
        $erreurs['message'] = "<p>Le message doit contenir entre 10 et 3000 caractères!</p>";
    }


    if (!empty($erreurs)) {
        $valeursEchappees['nom'] = htmlspecialchars($nom);
        $valeursEchappees['email'] = htmlspecialchars($email);
        $valeursEchappees['message'] = htmlspecialchars($message);
        $valeursEchappees['prenom'] = htmlspecialchars($prenom);
    }

    return [$erreurs, $valeursEchappees];
}catch (PDOException $e) {
    gererExceptions($e);
    return false;
} finally {
    // Libérer la connexion
    $pdo = null;
}}

// ============================
// TRAITEMENT INSCRIPTION
// ============================

function traiterFormulaireInscription($post, $pdo) {
    $erreurs = [];
    $valeursEchappees = [];

    try{
    $pseudo = trim($post['inscription_pseudo'] ?? '');
    $email = trim($post['inscription_email'] ?? '');
    $motDePasse = trim($post['inscription_motDePasse'] ?? '');
    $motDePasseConfirmation = trim($post['inscription_motDePasse_confirmation'] ?? '');

    // Pseudo
    if ($pseudo === '') {
        $erreurs['pseudo'] = "<p>Le pseudo est requis !</p>";
    } elseif (mb_strlen($pseudo) < 2 || mb_strlen($pseudo) > 255) {
        $erreurs['pseudo'] = "<p>Le pseudo doit contenir entre 2 et 255 caractères !</p>";
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM t_utilisateur_uti WHERE uti_pseudo = ?");
        $stmt->execute([$pseudo]);
        if ($stmt->fetchColumn() > 0) {
            $erreurs['pseudo'] = "<p>Ce pseudo est déjà utilisé !</p>";
        }
    }

    // Email
    if ($email === '') {
        $erreurs['email'] = "<p>L'email est requis !</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = "<p>Adresse email invalide !</p>";
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM t_utilisateur_uti WHERE uti_email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $erreurs['email'] = "<p>Cette adresse email est déjà utilisée !</p>";
        }
    }

    // Mot de passe
    if ($motDePasse === '' || $motDePasseConfirmation === '') {
        $erreurs['motDePasse'] = "<p>Le mot de passe et sa confirmation sont requis !</p>";
    } elseif ($motDePasse !== $motDePasseConfirmation) {
        $erreurs['motDePasse'] = "<p>Les mots de passe ne correspondent pas !</p>";
    } elseif (mb_strlen($motDePasse) < 8 || mb_strlen($motDePasse) > 72) {
        $erreurs['motDePasse'] = "<p>Le mot de passe doit contenir entre 8 et 72 caractères !</p>";
    }

    // Si pas d'erreurs, insertion
    if (empty($erreurs)) {
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email, uti_motdepasse) VALUES (?, ?, ?)");
        $stmt->execute([$pseudo, $email, $motDePasseHash]);
    } else {
        $valeursEchappees = [
            'pseudo' => htmlspecialchars($pseudo),
            'email' => htmlspecialchars($email)
        ];
    }

    return [$erreurs, $valeursEchappees];
}catch (PDOException $e) {
    gererExceptions($e);
    return false;
} finally {
    // Libérer la connexion
    $pdo = null;
}}
?>