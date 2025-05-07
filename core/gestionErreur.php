<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

function gererExceptions(Exception $e): void
{
    if (defined('DEV_MODE') && DEV_MODE === true)
    {
        echo "Une erreur est survenue : " . $e->getMessage() . PHP_EOL;
    }
    else
    {
        $cheminLog = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'erreurs.log';

        $message = date('[Y-m-d H:i:s] ') . $e->getMessage() . PHP_EOL;

        error_log($message, 3, $cheminLog);
    }
}
?>