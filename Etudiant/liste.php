<?php
include('../include/header.php');
// include('../include/sidebar.php');

//connexion à la base de donné
require_once("../conn.php");

$editStudent = null;
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM etudiant WHERE Matriculle = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    $editStudent = $stmt->fetch(PDO::FETCH_ASSOC);
}

//requête pour la sélection des étudiants dans la BD
$sql = "SELECT * FROM etudiant";
$stmt = $connexion->prepare($sql);
$stmt->execute();

//récuppération des donnnée
$student =
    $stmt->fetchAll(PDO::FETCH_ASSOC);

    
   require_once("../conn.php");

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Requête unique
$sql = "SELECT * FROM etudiant WHERE 1=1";

// si recherche
if (!empty($search)) {
    $sql .= " AND (
        Matriculle LIKE :search
        OR Nom LIKE :search
        OR Prénoms LIKE :search
    )";
}

$stmt = $connexion->prepare($sql);

// bind seulement si recherche
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}

$stmt->execute();

$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($etudiants as $e): ?>
<tr>
    <td><?= $e['Matriculle'] ?></td>
    <td><?= $e['Nom'] ?></td>
    <td><?= $e['Prénoms'] ?></td>
</tr>
<?php endforeach; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <!-- <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

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

        #Mat {
            text-align: center;

        }

        #Name {
            /* text-transform: Capitalize(); */
            text-align: left;

        }

        #Lastname {
            width: 160px;
            text-align: left;
        }
    </style>
</head>

<body>

    <form method="GET" action="">
        <input type="text" name="search" placeholder="Rechercher un étudiant...">
        <button type="submit">Rechercher</button>
    </form>
    <h1 class="titre">Liste de étudiants</h1>

    <table class="liste">
        <tr>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Niveau</th>
            <th>Parcours</th>
            <th colspan="2">Action</th>

        </tr>
    


        <?php foreach ($student as $student): ?>

            <?php if ($editStudent && $student['Matriculle'] == $editStudent['Matriculle']) : ?>

                <form action="edit.php" method="POST">

                    <tr>

                        <td>
                            <input type="hidden" name="Matriculle" value="<?= $student['Matriculle'] ?>">
                            <?= $student['Matriculle'] ?>
                        </td>

                        <td>
                            <input type="text" name="Nom" value="<?= $student['Nom'] ?>">
                        </td>

                        <td>
                            <input type="text" name="Prénoms" value="<?= $student['Prénoms'] ?>">
                        </td>

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
                            <button type="submit">Valider</button>
                        </td>

                        <td>
                            <a href="delete.php?id=<?= urlencode($student['Matriculle']) ?>" onclick="confirm('voulez vous suprimer cette étudiant???')">Delete</a>
                        </td>

                    </tr>

                </form>

            <?php else: ?>

                <tr>

                    <td><?= $student['Matriculle'] ?></td>
                    <td><?= $student['Nom'] ?></td>
                    <td><?= $student['Prénoms'] ?></td>
                    <td><?= $student['Niveau'] ?></td>
                    <td><?= $student['Parcours'] ?></td>

                    <td>
                        <a href="delete.php?id=<?= urlencode($student['Matriculle']) ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet étudiant ?')">Delete</a>
                    </td>

                    <td>
                        <a href="liste.php?id=<?= $student['Matriculle'] ?>">Edit</a>
                    </td>

                </tr>

            <?php endif; ?>

        <?php endforeach; ?>
    </table>

    <h2>Ajouter un étudiant</h2>

    <form action="insert.php" method="POST">

        <input type="text" name="Matriculle" placeholder="Matricule" required>
        <br><br>

        <input type="text" name="Nom" placeholder="Nom" required>
        <br><br>

        <input type="text" name="Prénoms" placeholder="Prénoms" required>
        <br><br>

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

        <button type="submit">Ajouter</button>

    </form>

</body>

</html>