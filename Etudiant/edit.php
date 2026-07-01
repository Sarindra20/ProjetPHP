<?php
require_once("../conn.php");

if (
    isset($_POST['Matriculle']) &&
    isset($_POST['Nom']) &&
    isset($_POST['Prénoms']) &&
    isset($_POST['Niveau']) &&
    isset($_POST['Parcours'])
) {

    $sql = "UPDATE etudiant
            SET Nom = ?, Prénoms = ?, Niveau = ?, Parcours = ?
            WHERE Matriculle = ?";

    $stmt = $connexion->prepare($sql);

    $stmt->execute([
        $_POST['Nom'],
        $_POST['Prénoms'],
        $_POST['Niveau'],
        $_POST['Parcours'],
        $_POST['Matriculle']
    ]);

    header("Location: liste.php");
    exit();

} else {

    echo "Tous les champs sont obligatoires.";

}
?>