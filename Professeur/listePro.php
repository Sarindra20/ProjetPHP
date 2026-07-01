<?php 
include('../include/header.php');

    //connexion à la base de donné
   require_once("../conn.php");

    //requête pour la sélection des professeurs dans la BD
    $sql = "SELECT * FROM professeur";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    //récuppération des donnnée
    $teacher=
    $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Proffeseurs</title>

    <style class="css">
         table,td,tr,th{
            border: 1px solid #000000;
                        margin-top: 70px;
            margin-left: 150px;

        }
        th{
            background-attachment: fixed;
            background-color: #04371d;
            height: 30px;
            width: 120px;
            text-align: center;
            color: #ffff;
            font-style: sans-serif;
        }
        td,tr{
                        text-align: left;
                        background-color: #9ae1bd;
                                    height: 30px;
            width: 120px;
        text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="titre">Liste des Professeur</h1>

    <table class="liste">
        <tr>
            <th>Id Professeur</th>
            <th>Nom Professeur</th>
            <th>Prénom Professeur</th>
            <th>Civilité</th>
            <th>Grade</th>
        </tr>

        <?php 
        foreach ($teacher as $teacher):
        ?>
        <tr>
            <td>
                <?= $teacher['Id_Prof'] ?>
            </td>

                        <td>
                <?= $teacher['Nom_Prof'] ?>
            </td>
            <td>
                <?= $teacher['Prenom_Prof'] ?>
            </td>
            <td>
                <?= $teacher['Civilite'] ?>
            </td>
            <td>
                <?= $teacher['Grade'] ?>
            </td>

            <!-- <a href="Etudiant/edti.php" class="edit">MODIFIER</a> -->
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>