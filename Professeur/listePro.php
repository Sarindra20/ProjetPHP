<?php
include('../include/header.php');

// Connexion à la base de données
require_once("../conn.php");

$editProf = null;

// Si on clique sur Edit
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM professeur WHERE Id_Prof = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    $editProf = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Liste des professeurs
$sql = "SELECT * FROM professeur";
$stmt = $connexion->prepare($sql);
$stmt->execute();

$teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Professeurs</title>

    <style>
        table,
        td,
        tr,
        th {
            border: 1px solid #000000;
            margin-top: 70px;
            margin-left: 150px;
            border-collapse: collapse;
        }

        h1 {
            margin-top: 50px;
            margin-left: 150px;
        }

        th {
            background-color: #04371d;
            color: white;
            height: 30px;
            width: 120px;
            text-align: center;
        }

        td {
            text-align: center;
            background-color: #9ae1bd;
            height: 30px;
            width: 120px;
        }
    </style>
</head>

<body>

<h1>Liste des Professeurs</h1>

<table>

    <tr>
        <th>Id Professeur</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Civilité</th>
        <th>Grade</th>
        <th colspan="2">Action</th>
    </tr>

    <?php foreach ($teacher as $t): ?>

        <?php if ($editProf && $t['Id_Prof'] == $editProf['Id_Prof']) : ?>

            <form action="editPro.php" method="POST">

                <tr>

                    <td>
                        <input type="hidden"
                               name="old_id_prof"
                               value="<?= $t['Id_Prof'] ?>">

                        <input type="text"
                               name="Id_Prof"
                               value="<?= $t['Id_Prof'] ?>">
                    </td>

                    <td>
                        <input type="text"
                               name="Nom_Prof"
                               value="<?= $t['Nom_Prof'] ?>">
                    </td>

                    <td>
                        <input type="text"
                               name="Prenom_Prof"
                               value="<?= $t['Prenom_Prof'] ?>">
                    </td>

                   <td>
    <select name="Civilite">
        <option value="Mr" <?= $t['Civilite']=="Mr" ? "selected" : "" ?>>Mr</option>
        <option value="Mlle" <?= $t['Civilite']=="Mlle" ? "selected" : "" ?>>Mlle</option>
        <option value="Mme" <?= $t['Civilite']=="Mme" ? "selected" : "" ?>>Mme</option>
    </select>
</td>

<td>
    <select name="Grade">
        <option value="Professeur Titulaire" <?= $t['Grade']=="Professeur Titulaire" ? "selected" : "" ?>>
            Professeur Titulaire
        </option>

        <option value="Maître de conférence" <?= $t['Grade']=="Maître de conférence" ? "selected" : "" ?>>
            Maître de conférence
        </option>

        <option value="Assistant d'enseignement Supérieur et de recherche"
            <?= $t['Grade']=="Assistant d'enseignement Supérieur et de recherche" ? "selected" : "" ?>>
            Assistant d'enseignement Supérieur et de recherche
        </option>

        <option value="Docteur HDR" <?= $t['Grade']=="Docteur HDR" ? "selected" : "" ?>>
            Docteur HDR
        </option>

        <option value="Docteur en informatique"
            <?= $t['Grade']=="Docteur en informatique" ? "selected" : "" ?>>
            Docteur en informatique
        </option>

        <option value="Doctorat en informatique"
            <?= $t['Grade']=="Doctorat en informatique" ? "selected" : "" ?>>
            Doctorat en informatique
        </option>
    </select>
</td>

                    <td>
                        <button type="submit">Valider</button>
                    </td>

                    <td>
                        <a href="deletePro.php?id=<?= urlencode($t['Id_Prof']) ?>"
                           onclick="return confirm('Voulez-vous supprimer ce professeur ?')">
                            Delete
                        </a>
                    </td>

                </tr>

            </form>

        <?php else: ?>

            <tr>

                <td><?= $t['Id_Prof'] ?></td>
                <td><?= $t['Nom_Prof'] ?></td>
                <td><?= $t['Prenom_Prof'] ?></td>
                <td><?= $t['Civilite'] ?></td>
                <td><?= $t['Grade'] ?></td>

                <td>
                    <a href="deletePro.php?id=<?= urlencode($t['Id_Prof']) ?>"
                       onclick="return confirm('Voulez-vous supprimer ce professeur ?')">
                        Delete
                    </a>
                </td>

                <td>
                    <a href="listePro.php?id=<?= $t['Id_Prof'] ?>">
                        Edit
                    </a>
                </td>

            </tr>

        <?php endif; ?>

    <?php endforeach; ?>

</table>

<h2>Ajouter un professeur</h2>

<form action="insertPro.php" method="POST">

    <input type="text" name="Id_Prof" placeholder="Id Professeur" required>
    <br><br>

    <input type="text" name="Nom_Prof" placeholder="Nom" required>
    <br><br>

    <input type="text" name="Prenom_Prof" placeholder="Prénom" required>
    <br><br>

   <label>Civilité :</label>
<select name="Civilite" required>
    <option value="">--Choisir--</option>
    <option value="Mr">Mr</option>
    <option value="Mlle">Mlle</option>
    <option value="Mme">Mme</option>
</select>

    <label>Grade :</label>
<select name="Grade" required>
    <option value="">--Choisir--</option>
    <option value="Professeur Titulaire">Professeur Titulaire</option>
    <option value="Maître de conférence">Maître de conférence</option>
    <option value="Assistant d'enseignement Supérieur et de recherche">
        Assistant d'enseignement Supérieur et de recherche
    </option>
    <option value="Docteur HDR">Docteur HDR</option>
    <option value="Docteur en informatique">Docteur en informatique</option>
    <option value="Doctorat en informatique">Doctorat en informatique</option>
</select>

    <button type="submit">Ajouter</button>

</form>

</body>
</html>