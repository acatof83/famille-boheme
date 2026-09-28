<?php
header('Content-Type: application/json');

// Récupère le nom du dossier demandé
$folder = isset($_GET['folder']) ? $_GET['folder'] : '';

// Sécurité : empêche de remonter dans les dossiers parents
$folder = basename($folder);

if (!empty($folder) && is_dir($folder)) {
    $files = scandir($folder);
    $valid_files = array();
    
    // Extensions autorisées pour les photos et les vidéos
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'ogg');

    foreach ($files as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed_ext)) {
            $valid_files[] = $file;
        }
    }
    
    // Renvoie la liste au format JSON
    echo json_encode(array_values($valid_files));
} else {
    // Si le dossier n'existe pas ou est vide, on renvoie une liste vide
    echo json_encode(array());
}
?>