<?php
include('../include/header.php');
include('../include/sidebar.php');

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
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* BODY */
        body {
            background: #f4f6f9;
        }

        /* ESPACE SI SIDEBAR EXISTE */
        .main {
            margin-left: 240px;
            padding: 20px;
        }


        h1,
        h2 {
            color: #04371d;
            margin-bottom: 15px;
            margin-left: 150px;
        }

        table {
            width: 80%;
            margin-left: 150px;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #04371d;
            color: white;
            padding: 12px;
            font-size: 13px;
            text-align: center;
        }

        td {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            border-bottom: 1px solid #eee;
        }

        /* hover */
        tr:hover td {
            background: #f0f9f4;
        }

        td a {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
        }

        td a[href*="delete"] {
            background: #e74c3c;
            color: white;
        }

        td a[href*="listeOrg"] {
            background: #3498db;
            color: white;
        }

        form {
            margin-left: 150px;
            margin-top: 30px;
            background: white;
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        /* bouton ajouter */
        form button {
            width: 100%;
            padding: 10px;
            background: #04371d;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        form button:hover {
            background: #066b35;
        }

        /* INPUT EDIT TABLE */
        table input {
            width: 100%;
            padding: 6px;
            font-size: 12px;
        }

        .main {
            margin-left: 240px;
            padding: 20px;
        }

        table {
            margin-top: 70px;
        }

        .Organisme {
            margin-top: 60px;
            color: black;
        }
    </style>
</head>

<body>
    <div class="main">
        <h1 class="Organisme">Organisme</h1>

        <table class="liste">
            <tr>
                <th>Id Organisme</th>
                <th>Design</th>
                <th>Lieu</th>
                <th colspan="2">Action</th>

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
                                <a href="deleteOrg.php?id=<?= urlencode($t['Id_Organisme']) ?>" onclick="confirm('Voulez vous suprimer???')">Delete</a>
                            </td>
 <td>
                                <button type="submit">Valider</button>
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
    </div>


</body>
<?php
include('../include/footer.php');

?>


</html>