<?php
/* Fonction qui récupère toutes les tâches */
function getAllTaches($pdo) {
    $stmt = $pdo->prepare("SELECT id, titre, fait FROM taches");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
