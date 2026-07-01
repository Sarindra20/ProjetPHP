<?php
require_once("../conn.php");

if (
    isset($_POST['Id_Organisme']) &&
    isset($_POST['Design']) &&
    isset($_POST['Lieu'])
) {

    $sql = "UPDATE organisme
            SET Design = ?, Lieu = ?
            WHERE Id_Organisme = ?";

    $stmt = $connexion->prepare($sql);

    $stmt->execute([
        $_POST['Design'],
        $_POST['Lieu'],
        $_POST['Id_Organisme']
    ]);

    header("Location: liste.php");
    exit();

} else {

    echo "Tous les champs sont obligatoires.";

}
?>