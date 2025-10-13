<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('readJsonFile')) {

    /**
     * Lire un fichier JSON depuis un disque donné et retourner son contenu en tableau.
     *
     * @param string $disk   Le disque ('public', 'private', etc.)
     * @param string $path   Le chemin du fichier dans le disque
     * @return array|null    Le contenu JSON décodé en tableau, ou null si erreur
     */
    function readJsonFile(string $disk, string $path): ?array
    {
        // Vérifier si le fichier existe
        if (!Storage::disk($disk)->exists($path)) {
            // Fichier introuvable
            return null;
        }

        // Lire le contenu du fichier
        $jsonContent = Storage::disk($disk)->get($path);

        // Convertir le JSON en tableau PHP
        $data = json_decode($jsonContent, true);

        // Vérifier si le JSON est valide
        if ($data === null) {
            return null; // JSON invalide
        }

        return $data;
    }
}

if (!function_exists('readJsonFromPublic')) {

    /**
     * Lire un fichier JSON depuis le dossier public et retourner son contenu en tableau.
     *
     * @param string $relativePath  Chemin relatif depuis le dossier public (ex : 'data/countries.json')
     * @return array|null           Contenu JSON décodé en tableau, ou null si erreur
     */
    function readJsonFromPublic(string $relativePath): ?array
    {
        // Construire le chemin complet
        $filePath = public_path($relativePath);

        // Vérifier si le fichier existe
        if (!file_exists($filePath)) {
            return null; // Fichier introuvable
        }

        // Lire le contenu
        $jsonContent = file_get_contents($filePath);
        if ($jsonContent === false) {
            return null; // Erreur de lecture
        }

        // Décoder le JSON en tableau
        $data = json_decode($jsonContent, true);
        if ($data === null) {
            return null; // JSON invalide
        }

        return $data;
    }
}