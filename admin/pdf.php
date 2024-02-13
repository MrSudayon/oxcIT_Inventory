<?php
require('../fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();

// class pdf extends FPDF {
//     public function __construct() {
//         parent::FPDF();
//     }
//     public function build() {
//         //Add a new page 
//         $this->AddPage(); 
        
//         // Set the font for the text 
//         $this->SetFont('Arial', 'B', 18); 
        
//         // Prints a cell with given text  
//         $this->Cell(60,20,'Hello GeeksforGeeks!'); 
        
//         // return the generated output 
//         $this->Output(); 
//     }
// }

  
?>