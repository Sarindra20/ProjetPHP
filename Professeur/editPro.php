<?php
require_once("../conn.php");

if (
    isset($_POST['old_id_prof']) &&
    isset($_POST['Id_Prof']) &&
    isset($_POST['Nom_Prof']) &&
    isset($_POST['Prenom_Prof']) &&
    isset($_POST['Civilite']) &&
    isset($_POST['Grade']) 
) {

    $sql = "UPDATE professeur
            SET Id_Prof = ?,Nom_Prof = ?, Prenom_Prof = ?, Civilite = ?, Grade = ?
            WHERE Id_Prof = ?";

    $stmt = $connexion->prepare($sql);

    $stmt->execute([
    $_POST['Id_Prof'],   
    $_POST['Nom_Prof'],
    $_POST['Prenom_Prof'],
        $_POST['Civilite'],
    $_POST['Grade'],
    $_POST['old_id_prof']      
]);

    header("Location: listePro.php");
    exit();
} else {

    echo "Tous les champs sont obligatoires.";
}
