<?php
include('../include/header.php');
include('../include/sidebar.php');

require_once("../conn.php"); #mm commande que include
if (isset($_GET['recherche']) && !empty(trim($_GET['recherche']))) {

    $mot = "%" . trim($_GET['recherche']) . "%";

    $sql = "SELECT *
            FROM etudiant
            WHERE Matriculle LIKE ?
            OR Nom LIKE ?
            OR `Prénoms` LIKE ?
            ORDER BY Nom";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mot, $mot, $mot]);
} else {

    $sql = "SELECT * FROM etudiant ORDER BY Nom";

    $stmt = $connexion->prepare($sql);
    $stmt->execute();
}

$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
if (isset($_GET['recherche']) && !empty(trim($_GET['recherche']))) {

    $mot = "%" . trim($_GET['recherche']) . "%";

    $sql = "SELECT *
            FROM etudiant
            WHERE Matriculle LIKE ?
            OR Nom LIKE ?
            OR `Prénoms` LIKE ?
            ORDER BY Nom";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mot, $mot, $mot]);
} else {

    $sql = "SELECT * FROM etudiant ORDER BY Nom";

    $stmt = $connexion->prepare($sql);
    $stmt->execute();
}

$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="listStyle.css">
</head>

<body>

    <div class="main">
        <form method="GET" style="margin:20px; display:flex; gap:10px;" class="search">

            <input type="text"
                name="recherche"
                placeholder="Rechercher par matricule, nom ou prénom"
                value="<?= isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : '' ?>"
                style="padding:8px; width:250px;">

            <button type="submit" style="padding:8px 15px;" class="search">Search
            </button>

            <!-- bouton reset -->
            <a href="liste.php"  class="refresh" style="background-color:#3498db; color: white; width: 80px; height: 35px;font-size: 13px; text-align:center"> Refresh
            </a>

        </form>
        <h4>Liste des étudiants</h4>

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
                <?php foreach ($etudiants as $student): ?>

                    <!-- APPEL DE LA FONTION EDITsTUDENT SI L4USER APPUIE SUR LE BOUTON edit -->
                    <?php if ($editStudent && $student['Matriculle'] == $editStudent['Matriculle']) : ?>

                        <!-- FORMULAIRE QUI APPELERA LA FONTION DANS LE FIC edit.php POUR LA MODIFICATION -->
                        <form action="edit.php" method="POST" class="edition">
                            <tr>


                                <td>
                                    <!-- Ancien matricule -->
                                    <input type="hidden" name="old_matricule" value="<?= $student['Matriculle'] ?>">

                                    <!-- Nouveau matricule modifiable -->
                                    <input class="mll" type="text" name="Matriculle" value="<?= $student['Matriculle'] ?>">
                                </td>

                                <td><input class="name" type="text" name="Nom" style="text-transorm: uppercase;" value="<?= $student['Nom'] ?>"></td>

                                <td><input class="lastname"type="text" name="Prénoms" style="text-transform: capitalize;" value="<?= $student['Prénoms'] ?>"></td>

                                <td>
                                    <select class="niv" name="Niveau">
                                        <option value="L1" <?= $student['Niveau'] == "L1" ? "selected" : "" ?>>L1</option>
                                        <option value="L2" <?= $student['Niveau'] == "L2" ? "selected" : "" ?>>L2</option>
                                        <option value="L3" <?= $student['Niveau'] == "L3" ? "selected" : "" ?>>L3</option>
                                        <option value="M1" <?= $student['Niveau'] == "M1" ? "selected" : "" ?>>M1</option>
                                        <option value="M2" <?= $student['Niveau'] == "M2" ? "selected" : "" ?>>M2</option>
                                    </select>
                                </td>

                                <td>
                                    <select class=" par"name="Parcours">
                                        <option value="IG" <?= $student['Parcours'] == "IG" ? "selected" : "" ?>>IG</option>
                                        <option value="GB" <?= $student['Parcours'] == "GB" ? "selected" : "" ?>>GB</option>
                                        <option value="SR" <?= $student['Parcours'] == "SR" ? "selected" : "" ?>>SR</option>
                                    </select>
                                </td>


                                <td>
                                    <input  class="mail"type="email" name="adr_email" value="<?= $student['adr_email'] ?>">
                                </td>


                                <td>
                                    <button type="submit" class="valider">Valider</button>

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
           <div class="form-container">

    <h2>Ajouter un étudiant</h2>

    <form action="insert.php" method="POST" class="add">

        <div class="row">

            <div class="col">
                <input type="text" name="Matriculle" placeholder="Matricule" required>
            </div>

            <div class="col">
                <input type="text" name="Nom" placeholder="Nom" style="text-transform: uppercase;" required>
            </div>

        </div>

        <div class="row">

            <div class="col">
                <input type="text" name="Prénoms" placeholder="Prénoms" style="text-transform: capitalize;" required>
            </div>

            <div class="col">

                <select name="Niveau" required>
                    <option value="">Niveau</option>
                    <option value="L1">L1</option>
                    <option value="L2">L2</option>
                    <option value="L3">L3</option>
                    <option value="M1">M1</option>
                    <option value="M2">M2</option>
                </select>
            </div>

        </div>

        <div class="row">

            <div class="col">
                

                <select name="Parcours" required>
                    <option value="" placeholder="Parcours">Parcours</option>
                    <option value="IG">IG</option>
                    <option value="GB">GB</option>
                    <option value="SR">SR</option>
                </select>
            </div>

            <div class="col">
                <input type="email" name="adr_email" placeholder="Email" required>
            </div>

        </div>

        <button type="submit">
            Ajouter
        </button>

    </form>

</div>

</body>
<?php
include('../include/footer.php');

?>

</html>