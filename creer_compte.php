<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "immobilier";

// Create a connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to the database!";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Check if username or email already exists
    $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE nom_utilisateur = ? OR email = ?');
    $stmt->bind_param('ss', $nom_utilisateur, $email); // 'ss' means two string parameters
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = "Nom d'utilisateur ou email déjà utilisé.";
    } else {
        // Insert new user
        $stmt = $conn->prepare('INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, role) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $nom_utilisateur, $email, $mot_de_passe, $role); // 'ssss' means four string parameters
        if ($stmt->execute()) {
            $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de la création du compte.";
        }
    }
}

?>
