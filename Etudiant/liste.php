<?php
include('../include/header.php');
include('../include/sidebar.php');

require_once("../conn.php");

//code pour la modification direct des informations des étudiants sur la ligne
$editStudent = null;
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM etudiant WHERE Matriculle = ?"; //récupère l'id de l'étudiant concerné
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    $editStudent = $stmt->fetch(PDO::FETCH_ASSOC);
}

// liste étudiants
$sql = "SELECT * FROM etudiant"; //requête SQL ppour sélectionner tout les attributs de la table Etudiant de la BD
$stmt = $connexion->prepare($sql);
$stmt->execute();

$student = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>

    <!-- CSS -->
    <style>
        table,
        td,
        tr,
        th {
            border: 1px solid #000;
            border-collapse: collapse;
            margin-top: 70px;
            margin-left: 150px;
        }

        /* 
        h1 {
            margin-top: 50px;
            margin-left: 150px;
        } */

        th {
            background-color: #034c3c;
            color: white;
            height: 35px;
            text-align: center;
        }

        td {
            text-align: center;
            height: 30px;
            width: 100px;
        }

        a {
            margin: 5px;
            text-decoration: none;
        }

        /* .add{
            float: right;
        } */
    </style>
</head>

<body>

    <h4>Liste des étudiants</h4ss>

        <table>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Niveau</th> <!--tableau qui afficgera la liste des étudiant de la bd-->
                <th>Parcours</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

            <!-- bouble PHP qui va récupérer la liste des étudiants de la base de donnée puis de les afficher dans notre tableua -->
            <?php foreach ($student as $student): ?>

                <!-- APPEL DE LA FONTION EDITsTUDENT SI L4USER APPUIE SUR LE BOUTON edit -->
                <?php if ($editStudent && $student['Matriculle'] == $editStudent['Matriculle']) : ?>

                    <!-- FORMULAIRE QUI APPELERA LA FONTION DANS LE FIC edit.php POUR LA MODIFICATION -->
                    <form action="edit.php" method="POST">
                        <tr>


                            <td>
                                <!-- Ancien matricule -->
                                <input type="hidden" name="old_matricule" value="<?= $student['Matriculle'] ?>">

                                <!-- Nouveau matricule modifiable -->
                                <input type="text" name="Matriculle" value="<?= $student['Matriculle'] ?>">
                            </td>

                            <td><input type="text" name="Nom" value="<?= $student['Nom'] ?>"></td>

                            <td><input type="text" name="Prénoms" value="<?= $student['Prénoms'] ?>"></td>

                            <td>
                                <select name="Niveau">
                                    <option value="L1" <?= $student['Niveau'] == "L1" ? "selected" : "" ?>>L1</option>
                                    <option value="L2" <?= $student['Niveau'] == "L2" ? "selected" : "" ?>>L2</option>
                                    <option value="L3" <?= $student['Niveau'] == "L3" ? "selected" : "" ?>>L3</option>
                                    <option value="M1" <?= $student['Niveau'] == "M1" ? "selected" : "" ?>>M1</option>
                                    <option value="M2" <?= $student['Niveau'] == "M2" ? "selected" : "" ?>>M2</option>
                                </select>
                            </td>

                            <td>
                                <select name="Parcours">
                                    <option value="IG" <?= $student['Parcours'] == "IG" ? "selected" : "" ?>>IG</option>
                                    <option value="GB" <?= $student['Parcours'] == "GB" ? "selected" : "" ?>>GB</option>
                                    <option value="SR" <?= $student['Parcours'] == "SR" ? "selected" : "" ?>>SR</option>
                                </select>
                            </td>


                            <td>
                                <input type="email" name="adr_email" value="<?= $student['adr_email'] ?>">
                            </td>


                            <td>
                                <button type="submit">Valider</button>

                                <a href="delete.php?id=<?= urlencode($student['Matriculle']) ?>"
                                    onclick="return confirm('Supprimer cet étudiant ?')">
                                    Delete
                                </a>
                            </td>

                        </tr>
                    </form>

                    <!-- SINON, le tableau affiche seulement les listes -->
                <?php else: ?>

                    <tr>
                        <td><?= $student['Matriculle'] ?></td>
                        <td><?= $student['Nom'] ?></td>
                        <td><?= $student['Prénoms'] ?></td>
                        <td><?= $student['Niveau'] ?></td>
                        <td><?= $student['Parcours'] ?></td>


                        <td><?= $student['adr_email'] ?></td>


                        <td>
                            <a href="liste.php?id=<?= $student['Matriculle'] ?>">Edit</a>

                            <a href="delete.php?id=<?= urlencode($student['Matriculle']) ?>"
                                onclick="return confirm('Voulez-vous vraiment supprimer ?')">
                                Delete
                            </a>
                        </td>
                    </tr>

                <?php endif; ?>

            <?php endforeach; ?>

        </table>

        <!-- formulaire pour l,'ajout de l'étudiant -->
        <h2>Ajouter un étudiant</h2>

        <form action="insert.php" method="POST" class="add">

            <input type="text" name="Matriculle" placeholder="Matricule" required><br><br>

            <input type="text" name="Nom" placeholder="Nom" required><br><br>

            <input type="text" name="Prénoms" placeholder="Prénoms" required><br><br>

            <label>Niveau :</label>
            <select name="Niveau" required>
                <option value="">--Choisir--</option>
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
                <option value="M1">M1</option>
                <option value="M2">M2</option>
            </select>

            <br><br>

            <label>Parcours :</label>
            <select name="Parcours" required>
                <option value="">--Choisir--</option>
                <option value="IG">IG</option>
                <option value="GB">GB</option>
                <option value="SR">SR</option>
            </select>

            <br><br>

            <!-- EMAIL -->
            <input type="email" name="adr_email" placeholder="Email" required>

            <br><br>

            <button type="submit">Ajouter</button>

        </form>

</body>

</html>