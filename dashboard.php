<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: connexion.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenue, <?php echo ucfirst($_SESSION['role']); ?>!</h1>
    <p>Connecté en tant que <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>
