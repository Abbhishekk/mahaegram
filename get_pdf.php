<?php
require_once('lib/tcpdf1/tcpdf.php');

$pdf = new TCPDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('freeserif', '', 7); // smaller font
$pdf->AddPage();

// Title
$pdf->Cell(0, 10, 'नमुना ८ - कर आकारणी नोंदवही', 0, 1, 'C');

// Headers (27 columns)
$headers = [
    'अ.क्र', 'रहिवाशीचे नाव', 'गल्लीतले नाव', 'गट', 'भूमापन',
    'मालमत्ता क्रमांक', 'मालकाचे नाव', 'भोगवटाधारक',
    'मालमत्तेचे वर्णन', 'बांधकामाचे वर्ष', 'वयोमान', 'क्षेत्रफळ (चौ.मी)',
    'रेडीरेकनर दर', 'घसारा दर', 'इ.वापर भारांक', 'भांडवली मूल्य',
    'कराचा दर', 'वार्षिक कर (रु.)', 'अपील निकाल', 'फेरफार शेरा',
    'इमारत कर', 'स्वच्छता कर', 'आरोग्य कर', 'सावर्जनिक सुविधा कर',
    'एकूण (इमारत)', 'एकूण (जमीन)', 'एकूण (तपशीलवार)'
];

$data = [
    ['1', 'राम पाटील', 'डहाणू मार्ग', 'इतर', '30x38', 'P001', 'राम पाटील', '—', 'इमारत', '2013', '10', '105.91', '1040', '13352', '0.9', '1382845.69', '1', '866.90', '', '', '516', '20', '20', '75', '631', '', '866.9'],
    ['2', 'गणेश काळे', 'बांद्रापाडा', 'मिश्र', '25x22', 'P002', 'गणेश काळे', '—', 'मातीचे घर', '2007', '17', '50.00', '1040', '13352', '0.8', '545214.00', '1', '543.00', '', '', '446', '18', '20', '75', '559', '', '609.0'],
    // Add more rows as needed...
];

// Calculated column width
$colWidth = 400 / count($headers); // 14.81mm

// Build table manually
$html = '<table border="1" cellpadding="2" cellspacing="0"><thead><tr>';
foreach ($headers as $header) {
    $html .= '<th width="'.$colWidth.'mm">'.$header.'</th>';
}
$html .= '</tr></thead><tbody>';

foreach ($data as $row) {
    $html .= '<tr>';
    foreach ($row as $cell) {
        $html .= '<td width="'.$colWidth.'mm">'.htmlspecialchars($cell, ENT_QUOTES, 'UTF-8').'</td>';
    }
    $html .= '</tr>';
}
$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Output
$pdf->Output('namuna8_27column_fitted.pdf', 'I');
