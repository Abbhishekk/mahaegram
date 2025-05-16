<?php
require_once('lib/tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// Set document info
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Malmatta PDF Export');

// Set margins
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('freeserif', '', 10);

// Enable automatic page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

// HTML content
$html = <<<EOD
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 10px;
    }
    th, td {
        border: 1px solid black;
        padding: 4px;
        text-align: center;
        vertical-align: middle;
    }
    .rotate {
        writing-mode: vertical-rl;
        transform: rotate(180deg);
    }
</style>

<table>
    <thead>
        <tr>
            <th rowspan="2">अ. क्र.</th>
            <th rowspan="2" class="rotate">सरसावाचे नाव</th>
            <th rowspan="2" class="rotate">गल्लीतले नाव</th>
            <th rowspan="2" class="rotate">गाळा क्रमांक</th>
            <th rowspan="2" class="rotate">मालकाचे नाव</th>
            <th rowspan="2" class="rotate">भोगवटादाराचे नाव</th>
            <th rowspan="2">मालमत्तेचे वर्णन</th>
            <th rowspan="2">क्षेत्रफळ (चौ. फु.)</th>
            <th colspan="3">दर (रु. प्रति चौ. फु.)</th>
            <th rowspan="2">कर रक्कम</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">वार्षिक कर</th>
            <th rowspan="2">एकूण रक्कम</th>
        </tr>
        <tr>
            <th>जमीन</th>
            <th>इमारत</th>
            <th>इतर</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>१</td>
            <td class="rotate">खानुते</td>
            <td class="rotate">विक्रमभाऊ रत्ता</td>
            <td>१</td>
            <td>लाखु बेंद्रे</td>
            <td>खुद</td>
            <td>दोन खोल्यांचे घर</td>
            <td>२००</td>
            <td>५</td>
            <td>१०</td>
            <td>०</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>५१६</td>
            <td>२०</td>
            <td>८६६.९</td>
        </tr>
        <tr>
            <td>२</td>
            <td class="rotate">खानुते</td>
            <td class="rotate">विक्रमभाऊ रत्ता</td>
            <td>२</td>
            <td>सती तायां भोसले</td>
            <td>खुद</td>
            <td>एक मजल्याचे घर</td>
            <td>२५०</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>५</td>
            <td>१०</td>
            <td>०</td>
            <td>५३१</td>
            <td>२०</td>
            <td>६४६</td>
        </tr>
    </tbody>
</table>
EOD;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('malmatta_export.pdf', 'I');