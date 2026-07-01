<?php
require_once("../conn.php");

if (
    isset($_POST['Id_Prof']) &&
    isset($_POST['Nom_Prof']) &&
    isset($_POST['Prenom_Prof']) &&
    isset($_POST['Civilite']) &&
    isset($_POST['Grade'])
) {

    $sql = "INSERT INTO professeur(Id_Prof,Nom_Prof, Prenom_Prof, Civilite, Grade)
            VALUES (?, ?, ?,?,?)";

    $stmt = $connexion->prepare($sql);

    $stmt->execute([
        $_POST['Id_Prof'],
        $_POST['Nom_Prof'],
        $_POST['Prenom_Prof'],
        $_POST['Civilite'],
        $_POST['Grade'],
    ]);

    header("Location: listePro.php");
    exit();
} else {

    echo "Tous les champs sont obligatoires.";
}
