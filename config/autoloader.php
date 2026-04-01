<?php
// Strict
declare(strict_types=1);

// Enable all PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pretty errors
ini_set("html_errors", "1");
ini_set("error_prepend_string", "<pre style='color: #333; font-face:monospace; white-space: pre-wrap;font-size: 17px;color:#880808'>");
ini_set("error_append_string ", "</pre>");

// Autoload logic
spl_autoload_register(function ($className) {
    // Base directory (src)
    $baseDir = __DIR__ . '/../classes/';
    
    // Déterminer le répertoire en fonction du suffixe du nom de la classe
    switch (true) {       
        case substr($className, -7) === 'Manager':
            $directory = 'Managers';
            break;
        case substr($className, -6) === 'Mapper':
            $directory = 'Mappers';
            break;
        case substr($className, -10) === 'Repository':
            $directory = 'Repositories';
            break;
        case substr($className, -7) === 'Service':
            $directory = 'Services';
            break;
        default:
            $directory = 'Entities';
            break;
    }

    // Construire le chemin complet du fichier
    $file = $baseDir . $directory . '/' . $className . '.php';

    // Charge le fichier si trouvé
    if (file_exists($file)) {
        require $file;
    }
});

?>