<?php

class FileUploadHandler
{
    private const TYPES_AUTORISES = ['image/jpeg', 'image/png', 'image/webp'];
    private const TAILLE_MAX = 6 * 1024 * 1024; // 2 Mo

    // Valide et déplace un fichier uploadé vers le dossier de destination.
    // Retourne le nom du fichier généré, ou null si le fichier est invalide.
    public static function uploadImage($fichier, $dossierDestination)
    {
        if (!isset($fichier) || $fichier['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Vérification de la taille
        if ($fichier['size'] > self::TAILLE_MAX) {
            return null;
        }

        // Vérification du type MIME réel (lecture du contenu, pas du nom)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fichier['tmp_name']);

        if (!in_array($mimeType, self::TYPES_AUTORISES)) {
            return null;
        }

        // Vérification que le contenu est bien une image reconnue
        if (exif_imagetype($fichier['tmp_name']) === false) {
            return null;
        }

        // Génération d'un nom de fichier aléatoire et sûr
        $extension = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        };
        $nomFichier = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = $dossierDestination . '/' . $nomFichier;

        if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
            return null;
        }

        return $nomFichier;
    }
}