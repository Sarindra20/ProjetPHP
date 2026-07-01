<?php
require_once("../conn.php");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Supprimer d'abord dans soutenir
    $sql = "DELETE FROM soutenir WHERE Matriculle = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    // Puis supprimer dans etudiant
    $sql = "DELETE FROM etudiant WHERE Matriculle = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    header("Location: liste.php");
    exit();
}