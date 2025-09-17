<?php
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

/* On découpe l’URL */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));

/* On prend le dernier segment utile */
$endpoint = end($uri);

/* Si le dernier est "index.php", on regarde avant */
if ($endpoint === "index.php") {
    $endpoint = prev($uri);
}

/* Routage basique */
switch ($endpoint) {
    case "taches":
        require __DIR__ . "/src/controllers/tachesController.php";
        break;

    default:
        echo json_encode(["error" => "Endpoint non trouvé", "debug" => $uri]);
        break;
}
