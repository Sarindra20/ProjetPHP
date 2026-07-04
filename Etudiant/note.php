<?php
include('../include/header.php');
require_once("../conn.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notes des étudiants</title>

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

        form {
            margin-left: 100px;
            margin-top: 20px;
        }

        button {
            margin-left: 5px;
        }
    </style>
</head>

<body>

<h2 style="margin-left:100px;">Filtrer les notes par date</h2>

<!-- FORMULAIRE -->
<form method="GET">

    <label>Date début :</label>
    <input type="date" name="date1">

    <label>Date fin :</label>
    <input type="date" name="date2">

    <button type="submit">Rechercher</button>

    <!-- BOUTON RAFRAICHIR -->
    <button type="button" onclick="window.location.href='note.php'">
        Rafraîchir
    </button>

</form>

<?php

// FILTRE PAR DATE
if (isset($_GET['date1']) && isset($_GET['date2']) 
    && !empty($_GET['date1']) && !empty($_GET['date2'])) {

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];

    $sql = "SELECT 
                s.Matriculle,
                e.Nom,
                e.`Prénoms`,
                s.Note,
                s.Date_Soutenance
            FROM soutenir s
            INNER JOIN etudiant e 
                ON s.Matriculle = e.Matriculle
            WHERE s.Date_Soutenance BETWEEN ? AND ?
            ORDER BY s.Date_Soutenance";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([$date1, $date2]);

} else {

    // AFFICHAGE NORMAL
    $sql = "SELECT 
                s.Matriculle,
                e.Nom,
                e.`Prénoms`,
                s.Note,
                s.Date_Soutenance
            FROM soutenir s
            INNER JOIN etudiant e 
                ON s.Matriculle = e.Matriculle
            ORDER BY s.Date_Soutenance DESC";

    $stmt = $connexion->prepare($sql);
    $stmt->execute();
}

$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- TABLEAU -->
<table>

    <tr>
        <th>Matricule</th>
        <th>Nom</th>
        <th>Prénoms</th>
        <th>Note</th>
        <th>Date de soutenance</th>
    </tr>

    <?php foreach ($notes as $n): ?>
        <tr>
            <td><?= $n['Matriculle'] ?></td>
            <td><?= $n['Nom'] ?></td>
            <td><?= $n['Prénoms'] ?></td>
            <td><?= $n['Note'] ?></td>
            <td><?= $n['Date_Soutenance'] ?></td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>