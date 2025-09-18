<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - Bac Jaune</title>
</head>
<body>
    <h1>Connexion</h1>
    <form id="loginForm">
        <label>Email :</label>
        <input type="email" id="email" required><br><br>

        <label>Mot de passe :</label>
        <input type="password" id="password" required><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <div id="result"></div>

    <script>
    document.getElementById("loginForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        const res = await fetch("../index.php/auth/login", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            })
        });
        const data = await res.json();
        document.getElementById("result").innerText = JSON.stringify(data);
    });
    </script>
</body>
</html>
