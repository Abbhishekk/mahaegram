<?php
require_once('lib/tcpdf1/tcpdf.php');

$pdf = new TCPDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('freeserif', '', 7);
$pdf->AddPage();

// Title
$pdf->Cell(0, 10, 'नमुना ८ - कर आकारणी नोंदवही', 0, 1, 'C');

// Sample data (replace/add as needed)
$data = [
    ['1', 'राम पाटील', 'डहाणू मार्ग', 'इतर', '30x38', 'P001', 'राम पाटील', '—', 'इमारत', '2013', '10', '105.91', '1040', '13352', '0.9', '1382845.69', '1', '866.90', '', '', '516', '20', '20', '75', '631', '', '866.9'],
    ['2', 'गणेश काळे', 'बांद्रापाडा', 'मिश्र', '25x22', 'P002', 'गणेश काळे', '—', 'मातीचे घर', '2007', '17', '50.00', '1040', '13352', '0.8', '545214.00', '1', '543.00', '', '', '446', '18', '20', '75', '559', '', '609.0'],
];

// Build table with complex header and repeat on each page
$html = <<<EOD
<style> table, td { border-collapse: collapse; } </style>
<table border="1" cellpadding="2" cellspacing="0">
<thead>
<tr>
    <th rowspan="3">अ.क्र</th>
    <th rowspan="3">रहिवाशीचे नाव</th>
    <th rowspan="3">गल्लीतले नाव</th>
    <!-- Removed गट here -->
    <th rowspan="3">भूमापन</th>
    <th rowspan="3">मालमत्ता क्रमांक</th>
    <th rowspan="3">मालकाचे नाव</th>
    <th rowspan="3">भोगवटाधारक</th>
    <th rowspan="3">मालमत्तेचे वर्णन</th>
    <!-- Removed बांधकामाचे वर्ष here -->
    <th rowspan="3">वयोमान</th>
    <th rowspan="3">क्षेत्रफळ (चौ.मी)</th>
    <th rowspan="3">रेडीरेकनर दर</th>
    <th rowspan="3">घसारा दर</th>
    <th rowspan="3">इ.वापर भारांक</th>
    <th rowspan="3">भांडवली मूल्य</th>
    <th rowspan="3">कराचा दर</th>
    <th colspan="5">कराची रक्कम (रु.)</th>
    <th colspan="5">अपील निकाल व फेरफार</th>
    <th rowspan="3">फेरफार शेरा</th>
</tr>
<tr>
    <!-- Removed 4 headers for rotation -->
    <th>एकूण</th>
    <th>इमारत कर</th>
    <th>स्वच्छता कर</th>
    <th>आरोग्य कर</th>
    <th>सुविधा कर</th>
</tr>
</thead>
<tbody>
EOD;

foreach ($data as $row) {
    $html .= '<tr>';
    foreach ($row as $cell) {
        $html .= '<td>' . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . '</td>';
    }
    $html .= '</tr>';
}
foreach ($data as $row) {
    $html .= '<tr>';
    foreach ($row as $cell) {
        $html .= '<td>' . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');


// Example of Vertical Rotated Cell (you can use this logic for rotated header if needed)
// / Position 1: गट (rotate 90°)
$pdf->StartTransform();
$pdf->Rotate(90, 45, 50);
$pdf->MultiCell(30, 8, 'गट', 1, 'C', false, 1, 45, 50);
$pdf->StopTransform();

// Position 2: बांधकामाचे वर्ष
$pdf->StartTransform();
$pdf->Rotate(90, 75, 50);
$pdf->MultiCell(40, 8, 'बांधकामाचे वर्ष', 1, 'C', false, 1, 75, 50);
$pdf->StopTransform();

// Position 3–6: इमारत कर, स्वच्छता कर, आरोग्य कर, सुविधा कर
$xStart = 140;
$rotatedLabels = ['इमारत कर', 'स्वच्छता कर', 'आरोग्य कर', 'सुविधा कर'];
foreach ($rotatedLabels as $i => $label) {
    $x = $xStart + ($i * 12);
    $pdf->StartTransform();
    $pdf->Rotate(90, $x, 60);
    $pdf->MultiCell(30, 6, $label, 1, 'C', false, 1, $x, 60);
    $pdf->StopTransform();
}
$pdf->AddPage();
$pdf->SetFont('freeserif', '', 10);
$pdf->SetXY(20, 60);
$pdf->StartTransform();
$pdf->Rotate(90, 20, 60);
$pdf->MultiCell(50, 10, 'उलट शीर्षक', 1, 'C', false, 1);
$pdf->StopTransform();

// Output
$pdf->Output('namuna8_27column_fitted.pdf', 'I');