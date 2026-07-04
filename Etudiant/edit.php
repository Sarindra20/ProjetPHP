<?php
require_once("../conn.php");

if (
    isset($_POST['old_matricule'])&&
    isset($_POST['Matriculle']) &&
    isset($_POST['Nom']) &&
    isset($_POST['Prénoms']) &&
    isset($_POST['adr_email']) &&
    isset($_POST['Niveau']) &&
    isset($_POST['Parcours'])
) {

    $sql = "UPDATE etudiant
        SET Nom = ?, Prénoms = ?, Niveau = ?, Parcours = ?, adr_email = ?
        WHERE Matriculle = ?";

$stmt = $connexion->prepare($sql);

$stmt->execute([
    
    $_POST['Nom'],
    $_POST['Prénoms'],
    $_POST['Niveau'],
    $_POST['Parcours'],
    $_POST['adr_email'],
    $_POST['old_matricule']
]);

    header("Location: liste.php");
    exit();
} else {

    echo "Tous les champs sont obligatoires.";
}
