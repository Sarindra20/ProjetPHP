<?php
require_once("../conn.php");

if (
    isset($_POST['old_id_org']) &&
    isset($_POST['Id_Organisme']) &&
    isset($_POST['Design']) &&
    isset($_POST['Lieu'])
) {

    $sql = "UPDATE organisme
            SET Id_Organisme = ?,Design = ?, Lieu = ?
            WHERE Id_Organisme = ?";

    $stmt = $connexion->prepare($sql);

    $stmt->execute([
    $_POST['Id_Organisme'],   
    $_POST['Design'],
    $_POST['Lieu'],
    $_POST['old_id_org']      
]);

    header("Location: listeOrg.php");
    exit();
} else {

    echo "Tous les champs sont obligatoires.";
}
