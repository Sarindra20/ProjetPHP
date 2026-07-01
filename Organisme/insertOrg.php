<?php
require_once("../conn.php");

if (
    isset($_POST['Id_Organisme']) &&
    isset($_POST['Design']) &&
    isset($_POST['Lieu'])
) {

    $sql = "INSERT INTO organisme(Id_Organisme, Design, Lieu)
            VALUES (?, ?, ?)";

    $stmt = $connexion->prepare($sql);

    $stmt->execute([
        $_POST['Id_Organisme'],
        $_POST['Design'],
        $_POST['Lieu']
    ]);

    header("Location: listeOrg.php");
    exit();

} else {

    echo "Tous les champs sont obligatoires.";
}
?>