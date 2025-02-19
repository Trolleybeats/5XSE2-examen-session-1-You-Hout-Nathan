<?php
function generateMenu($links) {
    echo '<nav><ul>';

    $currentPage = basename($_SERVER['REQUEST_URI']);

    foreach ($links as $link => $url) {
    
        $activeClass = ($currentPage == $url) ? 'class="active"' : '';
        echo "<li $activeClass><a href='$url'>$link</a></li>";
    }
    
    echo '</ul></nav>';

}