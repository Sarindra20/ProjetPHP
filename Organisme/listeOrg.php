<?php
include('../include/header.php');

//connexion à la base de donné
require_once("../conn.php");
$editOrg = null;

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM organisme WHERE Id_Organisme = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    $editOrg = $stmt->fetch(PDO::FETCH_ASSOC);
}
//requête pour la sélection des organismes dans la BD
$sql = "SELECT * FROM organisme";
$stmt = $connexion->prepare($sql);
$stmt->execute();

//récuppération des donnnée
$org =
    $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>organisme</title>
    <style class="css">
        table,
        td,
        tr,
        th {
            border: 1px solid #000000;
            margin-top: 70px;
            margin-left: 150px;
        }

        h1 {
            margin-top: 50px;
            margin-left: 150px;


        }

        th {
            background-attachment: fixed;
            background-color: #f0a90f;
            height: 30px;
            width: 120px;
            text-align: center;
            color: #ffff;
            font-style: sans-serif;
        }

        td,
        tr {
            text-align: left;
            background-color: #ffffff;
            height: 30px;
            width: 120px;
            text-align: center;


        }
    </style>
</head>

<body>
    <h class="titre">Organisme</h1>

        <table class="liste">
            <tr>
                <th>Id Organisme</th>
                <th>Design</th>
                <th>Lieu</th>
                <th colspan="2">aCTION</th>

            </tr>

            <?php foreach ($org as $t): ?>

                <?php if ($editOrg && $t['Id_Organisme'] == $editOrg['Id_Organisme']) : ?>

                    <form action="editOrg.php" method="POST">

                        <tr>
                            <td>
                                <input type="hidden"
                                    name="old_id_org"
                                    value="<?= $t['Id_Organisme'] ?>">

                                <input type="text"
                                    name="Id_Organisme"
                                    value="<?= $t['Id_Organisme'] ?>">
                            </td>
                            <td>
                                <input type="text"
                                    name="Design"
                                    value="<?= $t['Design'] ?>">
                            </td>

                            <td>
                                <input type="text"
                                    name="Lieu"
                                    value="<?= $t['Lieu'] ?>">
                            </td>

                            <td>
                                <button type="submit">Valider</button>
                            </td>

                            <td>
                                <a href="deleteOrg.php?id=<?= urlencode($t['Id_Organisme']) ?>" onclick="confirm('Voulez vous suprimer???')">Delete</a>
                            </td>

                        </tr>

                    </form>

                <?php else: ?>

                    <tr>

                        <td><?= $t['Id_Organisme'] ?></td>
                        <td><?= $t['Design'] ?></td>
                        <td><?= $t['Lieu'] ?></td>


                        <td>
                            <a href="deleteOrg.php?id=<?= urlencode($t['Id_Organisme']) ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet étudiant ?')">Delete</a>
                        </td>

                        <td>
                            <a href="listeOrg.php?id=<?= $t['Id_Organisme'] ?>">Edit</a>
                        </td>

                    </tr>

                <?php endif; ?>

            <?php endforeach; ?>
        </table>

        <h2>Ajouter une organisme</h2>

        <form action="insertOrg.php" method="POST">

            <input type="text" name="Id_Organisme" placeholder="Id de l'Organisme" required>
            <br><br>

            <input type="text" name="Design" placeholder="Design" required>
            <br><br>

            <input type="text" name="Lieu" placeholder="Lieu" required>
            <br><br>


            <br><br>


            <button type="submit">Ajouter</button>

        </form>

</body>

</html>