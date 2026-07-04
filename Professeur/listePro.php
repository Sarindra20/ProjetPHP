<?php
include('../include/header.php');
include('../include/sidebar.php');

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

        /* ESPACE SIDEBAR */
.main{
    margin-left:240px;
    margin-top:90px;
    padding:30px;
}

        h1,
h2{
    width:90%;
    margin:30px auto 15px auto;
    color:#04371d;
    font-size:32px;
    font-weight:700;
}

        /* ===== TABLE ===== */
     table{
    width:90%;
    margin:20px auto;
    border-collapse:collapse;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 4px 15px rgba(0,0,0,.1);
}

        /* HEADER TABLE */
        th {
            background: #04371d;
            color: white;
            padding: 12px;
            font-size: 13px;
            text-align: center;
        }

        /* CELLULES */
        td {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            border-bottom: 1px solid #eee;
        }

        /* HOVER LIGNE */
        tr:hover td {
            background: #f0f9f4;
        }

        /* ===== INPUT EDIT DANS TABLE ===== */
        table input,
        table select {
            width: 100%;
            padding: 6px;
            font-size: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* ===== BOUTONS ACTION ===== */
        td a {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            margin: 2px;
            display: inline-block;
        }

        /* DELETE */
        td a[href*="delete"] {
            background: #e74c3c;
            color: white;
        }

        /* EDIT */
        td a[href*="listePro"] {
            background: #3498db;
            color: white;
        }

        /* ================= FORMULAIRE AJOUT ================= */

        form.add{
    width:90%;
    margin:20px auto 80px auto;

    background:white;
    border-radius:15px;
    padding:25px;

    box-shadow:0 4px 15px rgba(0,0,0,.12);
}

        /* Deux colonnes */

        .form-row {
            display: flex;
            gap: 25px;
            margin-bottom: 18px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            color: #04371d;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;

            border: 1px solid #ccc;
            border-radius: 8px;

            font-size: 14px;
        }

        /* Bouton */

        form.add button {
            margin-top: 15px;

            width: 100%;
            padding: 14px;

            border: none;
            border-radius: 8px;

            background: #04371d;
            color: white;

            font-size: 16px;
            cursor: pointer;
        }

        form.add button:hover {
            background: #066b35;
        }





        /* ===== BOUTON VALIDER EDIT ===== */
        button {
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            background: #04371d;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #066b35;
        }

        .main {
            margin-left: 240px;
            /* <-- espace réservé sidebar */
            padding: 20px;
        }
    

    </style>
</head>

<body>

    <div class="main">
        <h1 class="ldp">Liste des Professeurs</h1>

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
                                    <option value="Mr" <?= $t['Civilite'] == "Mr" ? "selected" : "" ?>>Mr</option>
                                    <option value="Mlle" <?= $t['Civilite'] == "Mlle" ? "selected" : "" ?>>Mlle</option>
                                    <option value="Mme" <?= $t['Civilite'] == "Mme" ? "selected" : "" ?>>Mme</option>
                                </select>
                            </td>

                            <td>
                                <select name="Grade">
                                    <option value="Professeur Titulaire" <?= $t['Grade'] == "Professeur Titulaire" ? "selected" : "" ?>>
                                        Professeur Titulaire
                                    </option>

                                    <option value="Maître de conférence" <?= $t['Grade'] == "Maître de conférence" ? "selected" : "" ?>>
                                        Maître de conférence
                                    </option>

                                    <option value="Assistant d'enseignement Supérieur et de recherche"
                                        <?= $t['Grade'] == "Assistant d'enseignement Supérieur et de recherche" ? "selected" : "" ?>>
                                        Assistant d'enseignement Supérieur et de recherche
                                    </option>

                                    <option value="Docteur HDR" <?= $t['Grade'] == "Docteur HDR" ? "selected" : "" ?>>
                                        Docteur HDR
                                    </option>

                                    <option value="Docteur en informatique"
                                        <?= $t['Grade'] == "Docteur en informatique" ? "selected" : "" ?>>
                                        Docteur en informatique
                                    </option>

                                    <option value="Doctorat en informatique"
                                        <?= $t['Grade'] == "Doctorat en informatique" ? "selected" : "" ?>>
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

        <form action="insertPro.php" method="POST" class="add">

            <div class="form-row">

                <div class="form-group">
                    <input type="text"
                        name="Id_Prof"
                        placeholder="Identifiant du professeur"
                        required>
                </div>

                <div class="form-group">
                    <input type="text"
                        name="Nom_Prof"
                        placeholder="Nom"
                        required>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group">
                    <input type="text"
                        name="Prenom_Prof"
                        placeholder="Prénom"
                        required>
                </div>

                <div class="form-group">
                    <select name="Civilite" required>
                        <option value="">Civilité</option>
                        <option value="Mr">Mr</option>
                        <option value="Mlle">Mlle</option>
                        <option value="Mme">Mme</option>
                    </select>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group">
                    <select name="Grade" required>
                        <option value="">Grade</option>

                        <option value="Professeur Titulaire">
                            Professeur Titulaire
                        </option>

                        <option value="Maître de conférence">
                            Maître de conférence
                        </option>

                        <option value="Assistant d'enseignement Supérieur et de recherche">
                            Assistant d'enseignement Supérieur et de recherche
                        </option>

                        <option value="Docteur HDR">
                            Docteur HDR
                        </option>

                        <option value="Docteur en informatique">
                            Docteur en informatique
                        </option>

                        <option value="Doctorat en informatique">
                            Doctorat en informatique
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <!-- Colonne vide pour équilibrer -->
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