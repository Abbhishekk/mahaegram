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
}
$html .= ' <th width="30" rowspan="3">क्र</th>
        <th width="80" rowspan="3">रस्त्याचे नाव</th>
        <th width="100" rowspan="3">गट क्र. भूमापन क्र</th>
        <th width="90" rowspan="3">माल मत्ता क्रमांक</th>
        <th width="60" rowspan="3">मालकाचे नाव (धारण करणाऱ्याचे नाव)</th>
        <th width="60" rowspan="3" >भोगवटा करणान्याचे
नाव</th>
        <th width="50" rowspan="3" >मालमत्तेचे वर्णन</th>
        <th width="50" rowspan="3" >भारांक</th>
        <th width="70" rowspan="3" >क्षेत्रफळ ची मी/(चौ.फू)</th>
        <th width="50" rowspan="1" colspan="3" >रेडीरेकनर दर प्रति
चो मी</th>
        <th width="60" rowspan="3" >घसारा दर</th>
        <th width="60" rowspan="3" >इ. वापरा नुसार भारांक</th>
        <th width="60" rowspan="3" >भांडवली मूल्य</th>
        <th width="60" rowspan="3" >करा चा दर</th>
        <th width="60" rowspan="1" colspan="5" >कराची रक्कम (रूपये)</th>
        <th width="60" rowspan="1" colspan="5" >अपिलाचे निकाल आणी त्यानंतर केलेले  फेरफार   (रूपये)</th>
        <th width="60" rowspan="3" >नंतर वाढकिंवा घट झालेल्या याबाबतीत आदेशाच्या संदर्भात शेरा</th> </tr>';
$html .= '<tr>
        <th width="60" rowspan="2" >जमिन</th>
        <th width="60" rowspan="2" >इमारत</th>
        <th width="60" rowspan="2" >बांधकाम</th>
        <th width="60" rowspan="2" >इमारत कर</th>
        <th width="60" rowspan="2" >दिवाबत्ती</th>
        <th width="60" rowspan="2" >आरोग्य</th>
        <th width="60" rowspan="2" >पाणी पटटी</th>
        <th width="60" rowspan="2" >एकूण</th>
        <th width="60" rowspan="2" >इमारत कर</th>
        <th width="60" rowspan="2" >दिवाबत्ती</th>
        <th width="60" rowspan="2" >आरोग्य</th>
        <th width="60" rowspan="2" >पाणी पटटी</th>
        <th width="60" rowspan="2" >एकूण</th>

       ';


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