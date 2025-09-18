<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Bac Jaune</title>
</head>
<body>
    <h1>Créer un compte</h1>
    <form id="registerForm">
        <label>Nom :</label>
        <input type="text" id="nom" required><br><br>

        <label>Email :</label>
        <input type="email" id="email" required><br><br>

        <label>Mot de passe :</label>
        <input type="password" id="password" required><br><br>

        <label>Rôle :</label>
        <select id="role">
            <option value="agent">Agent</option>
            <option value="responsable">Responsable</option>
        </select><br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <div id="result"></div>

    <script>
    document.getElementById("registerForm").addEventListener("submit", async (e) => {
        e.preventDefault();

        const res = await fetch("../index.php/auth/register", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                nom: document.getElementById("nom").value,
                email: document.getElementById("email").value,
                password: document.getElementById("password").value,
                role: document.getElementById("role").value
            })
        });

        const data = await res.json();
        document.getElementById("result").innerText = JSON.stringify(data, null, 2);
    });
    </script>
</body>
</html>
