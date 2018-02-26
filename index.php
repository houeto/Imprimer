<?php 


require_once 'fpdf/fpdf.php';

$bddname = 'db_gescolaire_2017';
$hostname = 'localhost';
$username = 'root';
$password = 'houeto';
$db = mysqli_connect ($hostname, $username, $password, $bddname);




class PDF extends FPDF {
    // Header
    function Header() {
        // Logo
       $this->Image('logo2.jpg',8,2,80);
        //Saut de ligne
        $this->Ln(20);
    }
    // Footer
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Adresse
        $this->Cell(196,5,'Imprimer par le logiciel Gescolaire',0,0,'C');
    }
}

// Activation de la classe
$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Helvetica','',11);
$pdf->SetTextColor(0);

// Liste des détails
$position_detail = 66; // Position à 8mm de l'entête

$req2 = "SELECT code_classe, lib_classe FROM ges_classe ";
$rep2 = mysqli_query($db, $req2);
while ($row2 = mysqli_fetch_array($rep2)) {
    $pdf->SetY($position_detail);
    $pdf->SetX(8);
    $pdf->MultiCell(30,8,utf8_decode($row2['code_classe']),1,'L');
    $pdf->SetY($position_detail);
    $pdf->SetX(38);
    $pdf->MultiCell(158,8,$row2['lib_classe'],1,'L');
    $pdf->SetY($position_detail);
    $pdf->SetX(176);
    $position_detail += 8;
}
// Position de l'entête à 10mm des infos (48 + 10)
$position_entete = 58;

function entete_table($position_entete){
    global $pdf;
    $pdf->SetDrawColor(183); // Couleur du fond
    $pdf->SetFillColor(221); // Couleur des filets
    $pdf->SetTextColor(0); // Couleur du texte
    $pdf->SetY($position_entete);
    $pdf->SetX(8);
    $pdf->Cell(30,8,'Code',1,0,'L',1);
    $pdf->SetX(38); // 8 + 96
    $pdf->Cell(158,8,'Libelle',1,0,'C',1);
    $pdf->SetX(176); // 104 + 10
    $pdf->Ln(); // Retour à la ligne
}
entete_table($position_entete);

// Nom du fichier
$nom = 'classe.pdf';

// Création du PDF
$pdf->Output($nom,'I');?>

?>
