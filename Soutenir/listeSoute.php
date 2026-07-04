<?php
include('../include/header.php');
include('../include/sidebar.php');

//connexion à la base de donné
require_once("../conn.php");

$editSoute = null;
// Si on clique sur Edit
$editSoute = null;

if (
    isset($_GET['matricule']) &&
    isset($_GET['organisme']) &&
    isset($_GET['annee'])
) {

    $matricule = $_GET['matricule'];
    $organisme = $_GET['organisme'];
    $annee = $_GET['annee'];

    $sql = "SELECT * FROM soutenir
            WHERE Matriculle = ?
            AND Id_Organisme = ?
            AND Annee_Universitaire = ?";

    $stmt = $connexion->prepare($sql);
    $stmt->execute([
        $matricule,
        $organisme,
        $annee
    ]);

    $editSoute = $stmt->fetch(PDO::FETCH_ASSOC);
}


//requête pour la sélection des soutenances dans la BD
$sql = "SELECT
s.*,
e.Nom,
e.`Prénoms`,
o.Design,

p1.Nom_Prof AS NomPresident,
p1.Prenom_Prof AS PrenomPresident,

p2.Nom_Prof AS NomExam,
p2.Prenom_Prof AS PrenomExam,

p3.Nom_Prof AS NomRapInt,
p3.Prenom_Prof AS PrenomRapInt,

p4.Nom_Prof AS NomRapExt,
p4.Prenom_Prof AS PrenomRapExt

FROM soutenir s

INNER JOIN etudiant e
ON s.Matriculle=e.Matriculle

INNER JOIN organisme o
ON s.Id_Organisme=o.Id_Organisme

LEFT JOIN professeur p1
ON s.President=p1.Id_Prof

LEFT JOIN professeur p2
ON s.Examinateur=p2.Id_Prof

LEFT JOIN professeur p3
ON s.Rapporteur_int=p3.Id_Prof

LEFT JOIN professeur p4
ON s.Rapporteur_ext=p4.Id_Prof;";
$stmt = $connexion->prepare($sql);
$stmt->execute();

//récuppération des donnnée
$soutenir =
    $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soutenance</title>
    <style class="css">
    
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

 
        body {
            background: #f4f6f9;
        }

    
        .main {
          
            margin-left: 240px;
            padding: 20px;
        }

  
        h1,
        h2 {
            margin-left: 150px;
            margin-bottom: 15px;
            color: #04371d;
        }

       

table{
    width:85%;
    margin:70px auto 0;
    border-collapse:collapse;
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 4px 15px rgba(0,0,0,.12);
    margin-top: 50px;
}

        /* HEADER TABLE */
        th {
            background: #04371d;
            color: white;
            padding: 12px;
            font-size: 12px;
            text-align: center;
        }

        /* CELLULES */
        td {
            padding: 8px;
            font-size: 11px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        /* HOVER */
        tr:hover td {
            background: #f0f9f4;
        }

        /* ===== INPUTS DANS EDIT ===== */
        table input,
        table select {
            width: 100%;
            padding: 5px;
            font-size: 11px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* ===== BOUTONS ACTION ===== */
        td a {
            padding: 5px 8px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 11px;
            margin: 2px;
            display: inline-block;
        }

        /* DELETE */
        td a[href*="delete"] {
            background: #e74c3c;
            color: white;
        }

        /* EDIT */
        td a[href*="listeSoute"] {
            background: #3498db;
            color: white;
        }

        /* PV BUTTON */
        td a[href*="pvSout"] {
            background: #8e44ad;
            color: white;
        }

        /* ===== FORM AJOUT ===== */
      /* ================= FORMULAIRE ================= */

.titre-form{
    width:85%;
    margin:45px auto 15px;
    font-size:30px;
    color:#04371d;
}

form.add{

    width:85%;
    margin:0 auto 80px;

    background:white;

    padding:25px;

    border-radius:15px;

    box-shadow:0 4px 15px rgba(0,0,0,.12);

}

.form-row{

    display:flex;

    gap:25px;

    margin-bottom:18px;

}

.form-group{

    flex:1;

}

.form-group input,
.form-group select{

    width:100%;

    padding:12px;

    border:1px solid #ccc;

    border-radius:8px;

    font-size:14px;

}

form.add button{

    width:100%;

    padding:14px;

    border:none;

    border-radius:8px;

    background:#04371d;

    color:white;

    font-size:16px;

    cursor:pointer;

}

form.add button:hover{

    background:#066b35;

}
        /* INPUTS FORM */
        form input,
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        /* BOUTON AJOUT */
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

        .main {
            margin-left: 240px;
            /* <-- espace réservé sidebar */
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="main">
        <h4 class="titre">Soutenance</h4>

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
                <th>Date Soutenance</th>
                <th colspan="3">Action</th>

            </tr>

            <?php foreach ($soutenir as $t): ?>

                <?php
                $enEdition = $editSoute &&
                    $t['Matriculle'] == $editSoute['Matriculle'] &&
                    $t['Id_Organisme'] == $editSoute['Id_Organisme'] &&
                    $t['Annee_Universitaire'] == $editSoute['Annee_Universitaire'];
                ?>

                <?php if ($enEdition): ?>

                    <form action="editSoute.php" method="POST">

                        <tr>

                            <input type="hidden" name="old_matricule" value="<?= $t['Matriculle'] ?>">
                            <input type="hidden" name="old_organisme" value="<?= $t['Id_Organisme'] ?>">
                            <input type="hidden" name="old_annee" value="<?= $t['Annee_Universitaire'] ?>">
                            <input type="hidden" name="Matriculle" value="<?= $t['Matriculle'] ?>">
                            <input type="hidden" name="Id_Organisme" value="<?= $t['Id_Organisme'] ?>">

                            <td><?= $t['Nom'] . " " . $t['Prénoms'] ?></td>

                            <td><?= $t['Design'] ?></td>

                            <td>
                                <input type="text"
                                    name="Annee_Universitaire"
                                    value="<?= $t['Annee_Universitaire'] ?>">
                            </td>

                            <td>
                                <input type="number"
                                    name="Note"
                                    min="0"
                                    max="20"
                                    value="<?= $t['Note'] ?>">
                            </td>

                            <!-- PRESIDENT -->

                            <td>

                                <select name="President">

                                    <?php
                                    $prof = $connexion->query("SELECT * FROM professeur ORDER BY Nom_Prof");

                                    while ($p = $prof->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                        <option
                                            value="<?= $p['Id_Prof'] ?>"

                                            <?= ($t['President'] == $p['Id_Prof']) ? "selected" : ""; ?>>

                                            <?= $p['Nom_Prof'] . " " . $p['Prenom_Prof'] ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </td>

                            <!-- EXAMINATEUR -->

                            <td>

                                <select name="Examinateur">

                                    <?php
                                    $prof = $connexion->query("SELECT * FROM professeur ORDER BY Nom_Prof");

                                    while ($p = $prof->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                        <option
                                            value="<?= $p['Id_Prof'] ?>"

                                            <?= ($t['Examinateur'] == $p['Id_Prof']) ? "selected" : ""; ?>>

                                            <?= $p['Nom_Prof'] . " " . $p['Prenom_Prof'] ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </td>

                            <!-- RAPPORTEUR INT -->

                            <td>

                                <select name="Rapporteur_int">

                                    <?php
                                    $prof = $connexion->query("SELECT * FROM professeur ORDER BY Nom_Prof");

                                    while ($p = $prof->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                        <option
                                            value="<?= $p['Id_Prof'] ?>"

                                            <?= ($t['Rapporteur_int'] == $p['Id_Prof']) ? "selected" : ""; ?>>

                                            <?= $p['Nom_Prof'] . " " . $p['Prenom_Prof'] ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </td>

                            <!-- RAPPORTEUR EXT -->

                            <td>

                                <select name="Rapporteur_ext">

                                    <?php
                                    $prof = $connexion->query("SELECT * FROM professeur ORDER BY Nom_Prof");

                                    while ($p = $prof->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                        <option
                                            value="<?= $p['Id_Prof'] ?>"

                                            <?= ($t['Rapporteur_ext'] == $p['Id_Prof']) ? "selected" : ""; ?>>

                                            <?= $p['Nom_Prof'] . " " . $p['Prenom_Prof'] ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            <td>
                                <input type="date" name="Date_Soutenance" value="<?= $t['Date_Soutenance'] ?>">
                            </td>
                            <td>
                                <button type="submit">Valider</button>
                            </td>

                            <td>

                                <a href="deleteSoute.php?matricule=<?= urlencode($t['Matriculle']) ?>&organisme=<?= urlencode($t['Id_Organisme']) ?>&annee=<?= urlencode($t['Annee_Universitaire']) ?>"
                                    onclick="return confirm('Voulez-vous supprimer cette soutenance ?')">

                                    Delete

                                </a>

                            </td>

                        </tr>

                    </form>

                <?php else: ?>

                    <tr>

                        <td><?= $t['Nom'] . " " . $t['Prénoms'] ?></td>

                        <td><?= $t['Design'] ?></td>

                        <td><?= $t['Annee_Universitaire'] ?></td>

                        <td><?= $t['Note'] ?></td>

                        <td><?= $t['NomPresident'] . " " . $t['PrenomPresident'] ?></td>

                        <td><?= $t['NomExam'] . " " . $t['PrenomExam'] ?></td>

                        <td><?= $t['NomRapInt'] . " " . $t['PrenomRapInt'] ?></td>

                        <td><?= $t['NomRapExt'] . " " . $t['PrenomRapExt'] ?></td>
                        <td><?= $t['Date_Soutenance'] ?></td>
                        <td>

                            <a href="deleteSoute.php?matricule=<?= urlencode($t['Matriculle']) ?>&organisme=<?= urlencode($t['Id_Organisme']) ?>&annee=<?= urlencode($t['Annee_Universitaire']) ?>"
                                onclick="return confirm('Voulez-vous supprimer cette soutenance ?')">

                                Delete

                            </a>

                        </td>

                        <td>

                            <a href="listeSoute.php?matricule=<?= urlencode($t['Matriculle']) ?>&organisme=<?= urlencode($t['Id_Organisme']) ?>&annee=<?= urlencode($t['Annee_Universitaire']) ?>">

                                Edit

                            </a>

                        </td>
                        <td>
                            <a href="../source/pvSout.php?matricule=<?= urlencode($t['Matriculle']) ?>">
                                Générer PV
                            </a>
                        </td>
                    </tr>

                <?php endif; ?>

            <?php endforeach; ?>
        </table>

        <h2 class="titre-form">Ajouter une soutenance</h2>

        <form action="insertSoute.php" method="POST" class="add">

            <div class="form-row">

                <div class="form-group">

                    <select name="Matriculle" required>
                        <option value="">Etudiant</option>

                        <?php
                        $sql = "SELECT * FROM etudiant ORDER BY Nom";
                        $stmt = $connexion->prepare($sql);
                        $stmt->execute();

                        while ($etu = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <option value="<?= $etu['Matriculle']; ?>">
                                <?= $etu['Nom']; ?> <?= $etu['Prénoms']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <select name="Id_Organisme" required>

                        <option value="">Organisme</option>

                        <?php
                        $sql = "SELECT * FROM organisme ORDER BY Design";
                        $stmt = $connexion->prepare($sql);
                        $stmt->execute();

                        while ($org = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <option value="<?= $org['Id_Organisme']; ?>">
                                <?= $org['Design']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

            </div>


            <div class="form-row">

                <div class="form-group">
                    <input
                        type="text"
                        name="Annee_Universitaire"
                        placeholder="Année universitaire"
                        required>
                </div>

                <div class="form-group">
                    <input
                        type="number"
                        name="Note"
                        placeholder="Note"
                        min="0"
                        max="20"
                        required>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group">

                    <select name="President" required>

                        <option value="">Président du jury</option>

                        <?php
                        $sql = "SELECT * FROM professeur ORDER BY Nom_Prof";
                        $stmt = $connexion->prepare($sql);
                        $stmt->execute();

                        while ($prof = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <option value="<?= $prof['Id_Prof']; ?>">
                                <?= $prof['Nom_Prof']; ?> <?= $prof['Prenom_Prof']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div class="form-group">

                    <select name="Examinateur" required>

                        <option value="">Examinateur</option>

                        <?php
                        $sql = "SELECT * FROM professeur ORDER BY Nom_Prof";
                        $stmt = $connexion->prepare($sql);
                        $stmt->execute();

                        while ($prof = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <option value="<?= $prof['Id_Prof']; ?>">
                                <?= $prof['Nom_Prof']; ?> <?= $prof['Prenom_Prof']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

            </div>


            <div class="form-row">

                <div class="form-group">

                    <select name="Rapporteur_int" required>

                        <option value="">Rapporteur interne</option>

                        <?php
                        $sql = "SELECT * FROM professeur ORDER BY Nom_Prof";
                        $stmt = $connexion->prepare($sql);
                        $stmt->execute();

                        while ($prof = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <option value="<?= $prof['Id_Prof']; ?>">
                                <?= $prof['Nom_Prof']; ?> <?= $prof['Prenom_Prof']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <select name="Rapporteur_ext" required>

                        <option value="">Rapporteur externe</option>

                        <?php
                        $sql = "SELECT * FROM professeur ORDER BY Nom_Prof";
                        $stmt = $connexion->prepare($sql);
                        $stmt->execute();

                        while ($prof = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <option value="<?= $prof['Id_Prof']; ?>">
                                <?= $prof['Nom_Prof']; ?> <?= $prof['Prenom_Prof']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

            </div>


            <div class="form-row">

                <div class="form-group">

                    <input
                        type="date"
                        name="Date_Soutenance"
                        required>

                </div>

                <div class="form-group"></div>

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