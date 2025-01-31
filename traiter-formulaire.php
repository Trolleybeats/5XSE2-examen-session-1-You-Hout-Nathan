<?php
function traiterFormulaire($post) {
    $erreurs = [];
    $valeursEchappees = [];


    $nom = trim($post['nom'] ?? '');
    $prenom = trim($post['prenom'] ?? '');
    $email = trim($post['email'] ?? '');
    $message = trim($post['message'] ?? '');

    if ($nom == '') {
        $erreurs['nom'] = "<p>Le nom est requis!</p>";
    } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 50) {
        $erreurs['nom'] = "<p>Le nom doit contenir entre 2 et 50 caractères!</p>";
    };

    if (mb_strlen($prenom) < 2 || mb_strlen($prenom) > 50) {
        $erreurs['prenom'] = "<p>Le prénom doit contenir entre 2 et 255 caractères!</p>";
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
        $valeursEchappees['prenom'] = htmlspecialchars($message);
    }

    return [$erreurs, $valeursEchappees];
}
?>