<?php
$method = $_SERVER['REQUEST_METHOD'];

/* On découpe l’URL */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));

/* On prend le dernier segment utile */
$endpoint = end($uri);

/* Si on appelle directement / ou index.php → on redirige vers le dashboard */
if ($endpoint === "index.php" || $endpoint === "bac-jaune" || $endpoint === "") {
    header("Location: views/dashboard.php");
    exit;
}

/* On force le JSON uniquement pour l’API */
header("Content-Type: application/json; charset=UTF-8");

/* Routage unique */
switch ($endpoint) {
    case "taches":
        require __DIR__ . "/src/controllers/tachesController.php";
        break;

    case "auth":
        require __DIR__ . "/src/controllers/authController.php";
        break;

    default:
        echo json_encode(["error" => "Endpoint non trouvé", "debug" => $uri]);
        break;
}
