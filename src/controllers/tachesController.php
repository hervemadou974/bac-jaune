<?php
/* 
 * Contrôleur des tâches
 * Gère tous les endpoints CRUD sur /taches
 */

/* Connexion à MySQL */
require __DIR__ . "/../../config/database.php";

/* Inclusion du modèle Tache */
require __DIR__ . "/../models/tache.php";

/* On récupère l’URL pour savoir si un ID est fourni */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));
$id = $uri[count($uri) - 1]; // dernier morceau de l’URL
if ($id === "taches") {
    $id = null; // pas d’ID
}

/* Selon la méthode HTTP */
switch ($method) {
    case "GET":
        if ($id) {
            // GET /taches/{id}
            $tache = getTacheById($pdo, $id);
            if ($tache) {
                echo json_encode($tache);
            } else {
                echo json_encode(["error" => "Tâche introuvable"]);
            }
        } else {
            // GET /taches
            $taches = getAllTaches($pdo);
            echo json_encode($taches);
        }
        break;

    case "POST":
        // POST /taches
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['titre'], $data['description'], $data['ville_id'], $data['user_id'])) {
            echo json_encode(["error" => "Champs manquants"]);
            break;
        }
        $id = createTache($pdo, $data['titre'], $data['description'], $data['ville_id'], $data['user_id']);
        echo json_encode([
            "success" => true,
            "message" => "Tâche créée avec succès",
            "id" => $id
        ]);
        break;

    case "PUT":
        // PUT /taches/{id}
        if (!$id) {
            echo json_encode(["error" => "ID requis"]);
            break;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['statut'])) {
            echo json_encode(["error" => "Champ 'statut' requis"]);
            break;
        }
        $rows = updateTache($pdo, $id, $data['statut']);
        echo json_encode([
            "success" => $rows > 0,
            "message" => $rows > 0 ? "Tâche mise à jour" : "Aucune modification"
        ]);
        break;

    case "DELETE":
        // DELETE /taches/{id}
        if (!$id) {
            echo json_encode(["error" => "ID requis"]);
            break;
        }
        $rows = deleteTache($pdo, $id);
        echo json_encode([
            "success" => $rows > 0,
            "message" => $rows > 0 ? "Tâche supprimée" : "Tâche introuvable"
        ]);
        break;

    default:
        echo json_encode(["error" => "Méthode non supportée"]);
        break;
}
