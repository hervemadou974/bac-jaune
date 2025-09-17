<?php
/* Connexion MySQL */
require __DIR__ . "/../../config/database.php";

/* Inclusion du modèle Tache */
require __DIR__ . "/../models/tache.php";

switch ($method) {
    case "GET":
        $taches = getAllTaches($pdo); // Appelle la fonction du modèle
        echo json_encode($taches);
        break;

    default:
        echo json_encode(["error" => "Méthode non supportée"]);
        break;
}
