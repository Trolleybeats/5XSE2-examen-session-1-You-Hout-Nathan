<?php

function connecter_utilisateur($email, $mot_de_passe){

if (session_status() === PHP_SESSION_NONE)
{
    ini_set('session.use_strict_mode', 1);
    ini_set('session.use_only_cookies', 1);

    // Calcul du temps de vie : 7 jours.
    $dureeDeVie = 60 * 60 * 24 * 7;

    if (!isset($_COOKIE[session_name()]))
    {
        session_set_cookie_params([
            'lifetime' => $dureeDeVie,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'lax'
        ]);
    }

    session_start();
}

$pdo=obtenirConnexionBdd();

try{
$stmt = $pdo->prepare("SELECT uti_id, uti_motdepasse FROM t_utilisateur_uti WHERE uti_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['uti_motdepasse'])) {
            // Connexion réussie : on enregistre l'ID de l'utilisateur en session
            $_SESSION['utilisateurId'] = $utilisateur['uti_id'];
        return true;
        } else {
            // Connexion échouée : identifiants incorrects
            return false;
        }

    } catch (PDOException $e) {
        gererExceptions($e);
    return false;
} finally {
    // Libérer la connexion
    $pdo = null;
}
}

function est_connecte() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['utilisateurId']);
}


function deconnecter_utilisateur() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Supprimer la variable de session spécifique à l'utilisateur
    unset($_SESSION['utilisateurId']);

    if (ini_get("session.use_cookies"))
{
    $params = session_get_cookie_params();

    setcookie(
        session_name(),     // Exemple : "PHPSESSID"
        '',                 // Valeur vide
        [
            'expires' => time() - 3600,
            'path' => $params['path'],
            'domain' => $params['domain']
        ]
    );
}

    session_destroy();
}


?>