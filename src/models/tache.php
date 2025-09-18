<?php
/*
 * Modèle Tâche
 * Contient toutes les fonctions SQL liées aux tâches
 */

/* Récupérer toutes les tâches */
function getAllTaches($pdo) {
    $sql = "SELECT t.id, t.titre, t.description, t.statut, 
                   u.nom AS agent, v.nom AS ville, 
                   t.created_at, t.updated_at
            FROM taches t
            LEFT JOIN users u ON t.user_id = u.id
            LEFT JOIN villes v ON t.ville_id = v.id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Récupérer une tâche précise par ID */
function getTacheById($pdo, $id) {
    $sql = "SELECT t.id, t.titre, t.description, t.statut, 
                   u.nom AS agent, v.nom AS ville, 
                   t.created_at, t.updated_at
            FROM taches t
            LEFT JOIN users u ON t.user_id = u.id
            LEFT JOIN villes v ON t.ville_id = v.id
            WHERE t.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Créer une nouvelle tâche */
function createTache($pdo, $titre, $description, $ville_id, $user_id) {
    $stmt = $pdo->prepare("
        INSERT INTO taches (titre, description, statut, ville_id, user_id)
        VALUES (:titre, :description, 'en_attente', :ville_id, :user_id)
    ");
    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':ville_id' => $ville_id,
        ':user_id' => $user_id
    ]);
    return $pdo->lastInsertId(); // retourne l'ID créé
}

/* Mettre à jour une tâche (statut) */
function updateTache($pdo, $id, $statut) {
    $stmt = $pdo->prepare("
        UPDATE taches 
        SET statut = :statut, updated_at = NOW() 
        WHERE id = :id
    ");
    $stmt->execute([
        ':statut' => $statut,
        ':id' => $id
    ]);
    return $stmt->rowCount(); // nombre de lignes modifiées
}

/* Supprimer une tâche */
function deleteTache($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM taches WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount(); // nombre de lignes supprimées
}
