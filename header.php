<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=<?=$metaDescription ?? ''?>>
    <title><?=$pageTitre ?? ''?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
    <?php

require_once 'navprincipale.php';


generateMenu([
    'Accueil' => 'index.php',
    'Contact' => 'contact.php'
]);
?>
    </header>
    <main>