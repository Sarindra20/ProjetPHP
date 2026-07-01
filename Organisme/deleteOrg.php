<?php
require_once("../conn.php");

// Récupérer l'ID depuis l'URL
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Requête SQL DELETE
    $sql = "DELETE FROM organisme WHERE Id_Organisme = ?";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    header("Location: liste.php");
    echo "Delete exécuté";
    exit();
} else {

    header("Location: liste.php");
    echo "Delete exécuté";
    exit();
}
