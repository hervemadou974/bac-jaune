<?php

/* Créer un utilisateur */
function registerUser($pdo, $nom, $email, $password, $role) {
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("
        INSERT INTO users (nom, email, password, role)
        VALUES (:nom, :email, :password, :role)
    ");
    $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':password' => $hash,
        ':role' => $role
    ]);

    return $pdo->lastInsertId();
}

/* Vérifier login et générer token */
function loginUser($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Token simple (id + email + timestamp encodé en base64)
        $token = base64_encode($user['id'] . "|" . $user['email'] . "|" . time());
        return $token;
    }
    return false;
}
