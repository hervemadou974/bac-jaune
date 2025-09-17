<?php
/* 
 * config/database.php
 * Fichier de connexion à MySQL via PDO
 */

$host = "localhost";   // Serveur MySQL
$dbname = "bacjaune";  // Nom de la base
$user = "root";        // Utilisateur MySQL
$pass = "";            // Mot de passe MySQL

try {
    /* Création de l’objet PDO */
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );

    /* On active le mode Exception pour mieux gérer les erreurs */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    /* Si la connexion échoue → on renvoie un JSON d’erreur */
    die(json_encode([
        "error" => "Impossible de se connecter à la base de données",
        "details" => $e->getMessage()
    ]));
}
