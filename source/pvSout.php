<?php
require('../fpdf/fpdf.php');
require_once("../conn.php");

if (!isset($_GET['matricule'])) {
    die("Matricule manquant");
}

$matricule = $_GET['matricule'];

#recuperation des données
$sql = "SELECT 
s.*,
e.Nom,
e.`Prénoms`,

p1.Nom_Prof AS NomPresident, #le nom du président  sera ici le nom du prof de la table professeur, celle squi est séléctionné
p1.Prenom_Prof AS PrenomPresident,
p1.Grade AS GradePresident,

p2.Nom_Prof AS NomExam,
p2.Prenom_Prof AS PrenomExam,
p2.Grade AS GradeExam,

p3.Nom_Prof AS NomRapInt,
p3.Prenom_Prof AS PrenomRapInt,
p3.Grade AS GradeRapInt,

p4.Nom_Prof AS NomRapExt,
p4.Prenom_Prof AS PrenomRapExt,
p4.Grade AS GradeRapExt

FROM soutenir s
INNER JOIN etudiant e ON s.Matriculle = e.Matriculle

LEFT JOIN professeur p1 ON s.President = p1.Id_Prof
LEFT JOIN professeur p2 ON s.Examinateur = p2.Id_Prof #les données de la tble professeur
LEFT JOIN professeur p3 ON s.Rapporteur_int = p3.Id_Prof
LEFT JOIN professeur p4 ON s.Rapporteur_ext = p4.Id_Prof

WHERE s.Matriculle = ?";

$stmt = $connexion->prepare($sql);
$stmt->execute([$matricule]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Aucune soutenance trouvée");
}

class PDF extends FPDF {

    function Header() {
        
    }

    function Footer() {
        // Pas de footer automatique
    }
}

$pdf = new PDF(); #nouvelle class pDF
$pdf->AddPage();

// Marges
$pdf->SetLeftMargin(25); #marge à gauche
$pdf->SetRightMargin(25); #marge à droite

#Titre du procès verbale
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'PROCES VERBAL',0,1,'C');
$pdf->Ln(2);
#Les sous titre
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,"SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE LICENCE",0,1,'C');
$pdf->Cell(0,8,'PROFESSIONNELLE',0,1,'C');
$pdf->Ln(2);

#Mention et parcours
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'Mention : ',0,1,'C');
$pdf->SetX(25);
$pdf->Cell(0,8,'Informatique',0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'Parcours : ',0,1,'C');
$pdf->SetX(25);
$pdf->Cell(0,8,'Informatique general',0,1,'C');

$pdf->Ln(5);
#Nom de l'étudiant
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,"Mr/Mlle " . strtoupper($data['Nom']) . " " . $data['Prénoms'],0,1,'L');
$pdf->Ln(5);

#object text
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,8,
"a soutenu publiquement son memoire de fin d'etudes pour l'obtention du diplome de Licence professionnelle",0,'L');

$pdf->Ln(5);

#Note de la soutenance
$pdf->SetFont('Arial','',12);
$noteTexte = "Apres la deliberation, la commission des membres du Jury a attribue la note de ";
$pdf->Write(8, $noteTexte);

$pdf->SetFont('Arial','B',12);
$pdf->Write(8, $data['Note'] . "/20");

$pdf->SetFont('Arial','',12);
$pdf->Write(8, " (dix-huit sur vingt)");

$pdf->Ln(15);

#Les jury
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Membres du Jury',0,1,'L');
$pdf->Ln(3);

# Président
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,8,'President : ',0,0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,"Mr " . $data['NomPresident'] . " " . $data['PrenomPresident'] . ", " . $data['GradePresident'],0,1,'L');

$pdf->Ln(2);

#Examinateur
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35,8,'Examinateur : ',0,0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,"Mr " . $data['NomExam'] . " " . $data['PrenomExam'] . ", " . $data['GradeExam'],0,1,'L');

$pdf->Ln(2);

# les Rapporteurs
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35,8,'Rapporteurs : ',0,0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,"Mlle " . $data['NomRapInt'] . " " . $data['PrenomRapInt'] . ", " . $data['GradeRapInt'],0,1,'L');

$pdf->SetX(60);
$pdf->Cell(0,8,"Mr " . $data['NomRapExt'] . " " . $data['PrenomRapExt'],0,1,'L');

$pdf->Output();
?>