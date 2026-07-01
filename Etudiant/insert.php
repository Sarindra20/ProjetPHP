<?php
require_once("../conn.php");

if (isset($_POST['Matriculle']) &&
    isset($_POST['Nom']) &&
    isset($_POST['Prénoms']) &&
    isset($_POST['Niveau']) &&
    isset($_POST['Parcours']))
{

    $matricule = $_POST['Matriculle'];
    $nom       = $_POST['Nom'];
    $prenom    = $_POST['Prénoms'];
    $niveau    = $_POST['Niveau'];
    $parcours  = $_POST['Parcours'];

    // Requête SQL
    $sql = "INSERT INTO etudiant(Matriculle, Nom, Prénoms, Niveau, Parcours)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([
        $matricule,
        $nom,
        $prenom,
        $niveau,
        $parcours
    ]);

    header("Location: liste.php");
    exit();

} else {

    echo "Tous les champs sont obligatoires.";
}
?>