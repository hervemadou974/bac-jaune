<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../models/user.php";

switch ($method) {
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);

        if ($uri[count($uri)-1] === "register") {
            // REGISTER
            if (!isset($data['nom'], $data['email'], $data['password'], $data['role'])) {
                echo json_encode(["error" => "Champs manquants"]);
                break;
            }
            $id = registerUser($pdo, $data['nom'], $data['email'], $data['password'], $data['role']);
            echo json_encode(["success" => true, "id" => $id]);

        } elseif ($uri[count($uri)-1] === "login") {
            // LOGIN
            if (!isset($data['email'], $data['password'])) {
                echo json_encode(["error" => "Champs manquants"]);
                break;
            }
            $token = loginUser($pdo, $data['email'], $data['password']);
            if ($token) {
                echo json_encode(["success" => true, "token" => $token]);
            } else {
                echo json_encode(["error" => "Identifiants invalides"]);
            }
        }
        break;

    default:
        echo json_encode(["error" => "Méthode non supportée"]);
        break;
}
