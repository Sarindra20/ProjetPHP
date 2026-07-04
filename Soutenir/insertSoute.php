<?php
require_once("../conn.php");

if (
    isset($_POST['Matriculle']) &&
    isset($_POST['Id_Organisme']) &&
    isset($_POST['Annee_Universitaire']) &&
    isset($_POST['Note']) &&
    isset($_POST['President']) &&
    isset($_POST['Examinateur']) &&
    isset($_POST['Rapporteur_int']) &&
    isset($_POST['Rapporteur_ext'])&&
    isset($_POST['Date_Soutenance'])
) {

   $sql = "INSERT INTO soutenir
(Matriculle, Id_Organisme, Annee_Universitaire, Note, President, Examinateur, Rapporteur_int, Rapporteur_ext, Date_Soutenance)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $connexion->prepare($sql);

$stmt->execute([
    $_POST['Matriculle'],
    $_POST['Id_Organisme'],
    $_POST['Annee_Universitaire'],
    $_POST['Note'],
    $_POST['President'],
    $_POST['Examinateur'],
    $_POST['Rapporteur_int'],
    $_POST['Rapporteur_ext'],
    $_POST['Date_Soutenance']
]);
    header("Location: listeSoute.php");
    exit();

} else {

    echo "Tous les champs sont obligatoires.";
}