<?php
require_once("../conn.php");

// Vérifier que les 3 paramètres existent
if (
    isset($_GET['matricule']) &&
    isset($_GET['organisme']) &&
    isset($_GET['annee'])
) {

    $matricule = $_GET['matricule'];
    $organisme = $_GET['organisme'];
    $annee = $_GET['annee'];

    // Requête de suppression
    $sql = "DELETE FROM soutenir
            WHERE Matriculle = ?
            AND Id_Organisme = ?
            AND Annee_Universitaire = ?";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([$matricule, $organisme, $annee]);

    header("Location: listeSoute.php");
    exit();

} else {

    header("Location: listeSoute.php");
    exit();
}