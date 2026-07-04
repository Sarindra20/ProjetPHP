<?php
include('../include/header.php');
require_once("../conn.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étudiants sans soutenance</title>

    <style>
        table, td, th {
            border: 1px solid #000;
            border-collapse: collapse;
            margin-top: 40px;
            margin-left: 100px;
        }

        th {
            background-color: #04371d;
            color: white;
            padding: 10px;
        }

        td {
            padding: 8px;
            text-align: center;
            background-color: #9ae1bd;
        }
    </style>
</head>

<body>

<h2 style="margin-left:100px;">Étudiants sans soutenance</h2>

<?php

$sql = "SELECT e.*
        FROM etudiant e
        LEFT JOIN soutenir s
        ON e.Matriculle = s.Matriculle
        WHERE s.Matriculle IS NULL
        ORDER BY e.Nom";

$stmt = $connexion->prepare($sql);
$stmt->execute();

$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table>

    <tr>
        <th>Matricule</th>
        <th>Nom</th>
        <th>Prénoms</th>
        <th>Niveau</th>
        <th>Parcours</th>
    </tr>

    <?php foreach ($etudiants as $e): ?>
        <tr>
            <td><?= $e['Matriculle'] ?></td>
            <td><?= $e['Nom'] ?></td>
            <td><?= $e['Prénoms'] ?></td>
            <td><?= $e['Niveau'] ?></td>
            <td><?= $e['Parcours'] ?></td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>