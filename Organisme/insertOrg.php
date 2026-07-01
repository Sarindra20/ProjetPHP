<?php
require_once("../conn.php");

if (isset($_POST['Id_Organisme']) &&
    isset($_POST['Design']) &&
    isset($_POST['Lieu']))
{

    $ido= $_POST['Id_Organisme'];
    $des      = $_POST['Design'];
    $lieu  = $_POST['Lieu'];

    // Requête SQL
    $sql = "INSERT INTO organisme(Id_Organisme,Design, Lieu)
            VALUES (?, ?, ?)";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([
       $ido,
        $des,
        $lieu
    ]);

    header("Location: liste.php");
    exit();

} else {

    echo "Tous les champs sont obligatoires.";
}
?>