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
    $mot_de_passe = $_POST['mot_de_passe'];

    // Check if the user exists
    $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE nom_utilisateur = ?');
    $stmt->bind_param('s', $nom_utilisateur); // 's' means the parameter is a string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Start session and store user data
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['nom_utilisateur'];

        // Redirect to dashboard or another page
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
