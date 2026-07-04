<?php
include('../include/header.php');
include('../include/sidebar.php');

require_once("../conn.php");

$sql = "SELECT Niveau, COUNT(*) AS total
        FROM etudiant
        GROUP BY Niveau
        ORDER BY Niveau";

$stmt = $connexion->prepare($sql);
$stmt->execute();

$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT COUNT(*) AS total_global FROM etudiant";
$stmt2 = $connexion->prepare($sql2);
$stmt2->execute();

$total = $stmt2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Effectif des étudiants</title>

    <style>
        table {
            border-collapse: collapse;
            margin-top: 50px;
            margin-left: 450px;
            width: 400px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #04371d;
            color: white;
        }

        h4 {
            padding-bottom: 240px;
        }

        h2,
        h4 {
            text-align: center;
        }

        .main {
            margin-left: 200px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="main">

        <h2>Effectif des étudiants par niveau</h2>

        <table>
            <tr>
                <th>Niveau</th>
                <th>Effectif</th>
            </tr>

            <?php foreach ($stats as $s): ?>
                <tr>
                    <td><?= $s['Niveau'] ?></td>
                    <td><?= $s['total'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h4>Total général : <?= $total['total_global'] ?> étudiants</h4>
    </div>

</body>

</html>
<?php
include('../include/footer.php');

?>