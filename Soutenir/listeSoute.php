<?php 
include('../include/header.php');

    //connexion à la base de donné
   require_once("../conn.php");

    //requête pour la sélection des soutenances dans la BD
    $sql = "SELECT * FROM soutenir";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    //récuppération des donnnée
    $soutenir=
    $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soutenance</title>
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
    <h1 class="titre">Soutenance</h1>

    <table class="liste">
    
            <tr>
    <th>Matricule</th>
    <th>Id Organisme</th>
    <th>Année Universitaire</th>
    <th>Note</th>
    <th>Président</th>
    <th>Examinateur</th>
    <th>Rapporteur interne</th>
    <th>Rapporteur externe</th>

        </tr>

        <?php 
        foreach (  $soutenir as   $soutenir):
        ?>
        <tr>
            <td>
                <?=   $soutenir['Matriculle'] ?>
            </td>
            <td>
                <?=   $soutenir['Id_Organisme'] ?>
            </td>
            <td>
                <?=   $soutenir['Annee_Universitaire'] ?>
            </td>
            <td>
                <?=  $soutenir['Note'] ?>
            </td>
            <td>
                <?=  $soutenir['President'] ?>
            </td>
            <td>
                <?=  $soutenir['Examinateur'] ?>
            </td>
            <td>
                <?=  $soutenir['Rapporteur_int'] ?>
            </td>
            <td>
                <?=  $soutenir['Rapporteur_ext'] ?>
            </td>

            <!-- <a href="Etudiant/edti.php" class="edit">MODIFIER</a> -->
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>