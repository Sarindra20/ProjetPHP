<?php
require_once("../conn.php");

// Récupérer l'ID depuis l'URL
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Requête SQL DELETE
    $sql = "DELETE FROM professeur WHERE Id_Prof = ?";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    header("Location: listePro.php");
    echo "Delete exécuté";
    exit();
} else {

    header("Location: listePro.php");
    echo "Delete exécuté";
    exit();
}
