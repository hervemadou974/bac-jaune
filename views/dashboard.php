<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Bac Jaune</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        #logout { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Dashboard</h1>

    <button id="logout">Déconnexion</button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Agent</th>
                <th>Ville</th>
                <th>Date création</th>
            </tr>
        </thead>
        <tbody id="taches">
            <tr><td colspan="7">Chargement...</td></tr>
        </tbody>
    </table>

    <script>
    async function chargerTaches() {
        const token = localStorage.getItem("token");
        if (!token) {
            // pas de login → retour login
            window.location.href = "login.php";
            return;
        }

        try {
            const res = await fetch("../index.php/taches", {
                headers: {
                    "Authorization": "Bearer " + token
                }
            });
            const data = await res.json();

            const tbody = document.getElementById("taches");
            tbody.innerHTML = "";

            if (Array.isArray(data)) {
                data.forEach(t => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${t.id}</td>
                        <td>${t.titre}</td>
                        <td>${t.description ?? ""}</td>
                        <td>${t.statut}</td>
                        <td>${t.agent ?? ""}</td>
                        <td>${t.ville ?? ""}</td>
                        <td>${t.created_at ?? ""}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="7">Erreur: ${data.error ?? "inconnue"}</td></tr>`;
            }
        } catch (err) {
            document.getElementById("taches").innerHTML = 
                `<tr><td colspan="7">Erreur réseau : ${err}</td></tr>`;
        }
    }

    // Déconnexion
    document.getElementById("logout").addEventListener("click", () => {
        localStorage.removeItem("token");
        window.location.href = "login.php";
    });

    chargerTaches();
    </script>
</body>
</html>
