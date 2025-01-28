<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $type = $_POST['type'];
    $localisation = $_POST['localisation'];

    // Gestion des fichiers téléchargés
    $photos = [];
    if (!empty($_FILES['photos']['name'][0])) {
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['photos']['name'][$key];
            $file_tmp = $_FILES['photos']['tmp_name'][$key];
            $upload_dir = 'uploads/';
            
            // Créer le dossier s'il n'existe pas
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_path = $upload_dir . basename($file_name);
            if (move_uploaded_file($file_tmp, $file_path)) {
                $photos[] = $file_path;
            }
        }
    }

    // Enregistrer les données dans la base de données
    $conn = new mysqli('localhost', 'root', '', 'real_estate');
    if ($conn->connect_error) {
        die('Erreur de connexion : ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO properties (title, description, price, type, location, owner_id, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $owner_id = 1; // Remplacez par l'ID du propriétaire connecté
    $stmt->bind_param('ssdssi', $titre, $description, $prix, $type, $localisation, $owner_id);
    if ($stmt->execute()) {
        echo "Propriété ajoutée avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
