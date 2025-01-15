<?php
// Fonction pour générer dynamiquement le menu principal
function generateMenu($links) {
    echo '<nav><ul>';
    
    // Récupération de la page actuelle à partir de $_SERVER
    $currentPage = basename($_SERVER['REQUEST_URI']);

    // Boucle sur chaque lien du menu
    foreach ($links as $link => $url) {
        // Détermination de la classe CSS à appliquer
        $activeClass = ($currentPage == $url) ? 'class="active"' : '';
        echo "<li $activeClass><a href='$url'>$link</a></li>";
    }
    
    echo '</ul></nav>';
}