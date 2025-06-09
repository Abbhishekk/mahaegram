<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

// Get filter parameters
$financial_year = $_GET['financial_year'] ?? '';
$panchayat_code = $_SESSION['panchayat_code'];
$book_number = $_GET['book_number'] ?? '';
$start_receipt = $_GET['start_receipt'] ?? '';
$end_receipt = $_GET['end_receipt'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$malmatta_number = $_GET['malmatta_number'] ?? '';
$person_name = $_GET['person_name'] ?? '';
$filter_type = $_GET['filter_type'] ?? 'all_register';

// Build query based on filters
$query = "SELECT DISTINCT kr.*, td.financial_year, 
                 lt.Village_Panchayat_Name_TLB_Name as gram_panchayat, 
                 lt.Development_Block_Name as taluka, lt.District_Name as district
          FROM karvasuli_records kr
            left join tax_demands td on kr.malamatta_kramanak = td.malmatta_id
         left OUTER join malmatta_data_entry mde on mde.id =  td.malmatta_id
         LEFT outer join new_name nn1 on mde.owner_name = nn1.id
        LEFT outer join new_name nn2 on mde.occupant_name = nn2.id
        left outer join lgdtable lt on lt.Village_Panchayat_Code_TLB_Code = mde.panchayat_code
          WHERE mde.panchayat_code = '$panchayat_code'";

$params = [':panchayat_code' => $panchayat_code];

// Apply filters
switch ($filter_type) {
    case 'book_number':
        if ($book_number) {
            $query .= " AND kr.pustak_kramanak = '$book_number'";
            $params[':book_number'] = $book_number;
        }
        break;

    case 'vasul_dinanknusar':
        if ($start_date) {
            $query .= " AND kr.vasul_dinank >= '$start_date'";
            $params[':start_date'] = $start_date;
        }
        if ($end_date) {
            $query .= " AND kr.vasul_dinank <= '$end_date'";
            $params[':end_date'] = $end_date;
        }
        break;

    case 'pavati_number_nusar':
        if ($book_number) {
            $query .= " AND kr.pustak_kramanak = '$book_number'";
            $params[':book_number'] = $book_number;
        }
        if ($start_receipt) {
            $query .= " AND kr.pavati_kramanak >= '$start_receipt'";
            $params[':start_receipt'] = $start_receipt;
        }
        if ($end_receipt) {
            $query .= " AND kr.pavati_kramanak <= '$end_receipt'";
            $params[':end_receipt'] = $end_receipt;
        }
        break;

    case 'malmaat_nusar':
        if ($malmatta_number) {
            $query .= " AND kr.malamatta_kramanak = '$malmatta_number'";
            $params[':malmatta_number'] = $malmatta_number;
        }
        break;

    case 'according_to_person':
        if ($person_name) {
            $query .= " AND nn1.person_name = '$person_name'";
            $params[':person_name'] = '%' . $person_name . '%';
        }
        break;
}

// Filter by financial year if selected
if ($financial_year) {
    $query .= " AND td.financial_year = '$financial_year'";
    $params[':financial_year'] = $financial_year;
}

$stmt = $db->prepare($query);
$stmt->execute();
$receipts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (empty($receipts)) {
    die("No receipts found matching the criteria");
}

// echo $query;

// Generate HTML for all receipts
$html = '';
foreach ($receipts as $receipt) {
    $html .= generateReceiptHtml($receipt);

}

// Function to generate HTML for a single receipt
function generateReceiptHtml($receipt)
{
    $total_previous = $receipt['previous_vasul_building_tax'] +
        $receipt['previous_vasul_health_tax'] +
        $receipt['previous_vasul_divabatti_tax'] +
        $receipt['previous_vasul_panniyojana_tax'];

    $total_current = $receipt['current_vasul_building_tax'] +
        $receipt['current_vasul_health_tax'] +
        $receipt['current_vasul_divabatti_tax'] +
        $receipt['current_vasul_panniyojana_tax'];

    $total_amount = $total_previous + $total_current;

    return '
    <!DOCTYPE html>
    <html lang="mr">
    <head>
        <meta charset="UTF-8">
        <title>करांची मागणी पावती</title>
        <style>
        body {
            font-family: "Mangal", "Noto Sans Devanagari", sans-serif;
            margin: 20px;
        }
        .receipt-box {
            border: 2px solid black;
            padding: 20px;
            page-break-after: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 18px;
        }
        caption {
            caption-side: top;
            font-weight: bold;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }
        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 20px;
        }
        .info-table td {
            border: none;
            padding: 5px;
            text-align: left;
        }
        .section {
            margin-top: 20px;
        }
        .footer-table {
            width: 100%;
            border: 1px solid black;
            margin-top: 30px;
        }
        .footer-table td {
            vertical-align: top;
            border: 1px solid black;
            padding: 10px;
        }
        .footer-table .full {
            padding: 10px;
            text-align: left;
        }
        .dashed-border {
            border-top: 2px dashed black;
            margin-top: 20px;
        }
        .boxc {
            font-size: 32px;
            border: 5px solid black;
            display: inline-block;
            padding: 4px;
            border-radius: 15px;
            box-shadow: 5px 10px 8px #888888;
        }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body {
                margin: 1.6cm;
            }
        }
        </style>
    </head>
    <body>
        <div class="receipt-box">
            <div style="font-size: 20px;">
                नियम ३२(५) पाहा
                <div class="header ">नमुना नं . १०</div>
            </div>
            <div class="header ">
                <span class="boxc">कर व फी बाबत पावती </span>
            </div>

            <table class="info-table">
                <tr>
                    <td colspan="2"><strong>ग्रामपंचायत :</strong> ' . htmlspecialchars($receipt['gram_panchayat']) . '</td>
                    <td><strong>तालुका :</strong> ' . htmlspecialchars($receipt['taluka']) . '</td>
                    <td><strong>जिल्हा :</strong> ' . htmlspecialchars($receipt['district']) . '</td>
                </tr>
                <tr>
                    <td colspan="3"><strong>पुस्तक क्रमांक:</strong> ' . htmlspecialchars($receipt['pustak_kramanak']) . '</td>
                    <td><strong>पावती क्रमांक:</strong> ' . htmlspecialchars($receipt['pavati_kramanak']) . '</td>
                </tr>
                <tr>
                    <td><strong>श्री . </strong> ' . htmlspecialchars($receipt['kar_denaryache_nav']) . '</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>यांचेकडून</strong> ' . htmlspecialchars($receipt['gram_panchayat']) . '</td>
                </tr>
                <tr>
                    <td><strong> मालमत्ता क्रमांक :</strong> ' . htmlspecialchars($receipt['malamatta_kramanak']) . '</td>
                    <td><strong>वॉर्ड क्रमांक :</strong> ' . htmlspecialchars($receipt['ward_kramanak']) . '</td>
                    <td><strong>आर्थिक वर्ष : </strong> ' . htmlspecialchars($receipt['financial_year']) . '</td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>सन ' . date('Y', strtotime($receipt['vasul_dinank'])) . ' याबद्दल पुढील करांची रक्कम मिळाली .</strong></td>
                </tr>
            </table>

            <table>
                <thead>
                    <tr>
                        <th rowspan="2">कराचे नाव</th>
                        <th colspan="3">वसूल पात्र रकमा</th>
                    </tr>
                    <tr>
                        <th>मागील</th>
                        <th>चालू</th>
                        <th>एकूण</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: left;">घरपट्टी/खुली जागा/इतर</td>
                        <td>' . number_format($receipt['previous_vasul_building_tax'], 2) . '</td>
                        <td>' . number_format($receipt['current_vasul_building_tax'], 2) . '</td>
                        <td>' . number_format($receipt['previous_vasul_building_tax'] + $receipt['current_vasul_building_tax'], 2) . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">दिवाबत्ती कर</td>
                        <td>' . number_format($receipt['previous_vasul_divabatti_tax'], 2) . '</td>
                        <td>' . number_format($receipt['current_vasul_divabatti_tax'], 2) . '</td>
                        <td>' . number_format($receipt['previous_vasul_divabatti_tax'] + $receipt['current_vasul_divabatti_tax'], 2) . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">आरोग्य कर</td>
                        <td>' . number_format($receipt['previous_vasul_health_tax'], 2) . '</td>
                        <td>' . number_format($receipt['current_vasul_health_tax'], 2) . '</td>
                        <td>' . number_format($receipt['previous_vasul_health_tax'] + $receipt['current_vasul_health_tax'], 2) . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">सामान्य पाणीपट्टी कर</td>
                        <td>' . number_format($receipt['previous_vasul_panniyojana_tax'], 2) . '</td>
                        <td>' . number_format($receipt['current_vasul_panniyojana_tax'], 2) . '</td>
                        <td>' . number_format($receipt['previous_vasul_panniyojana_tax'] + $receipt['current_vasul_panniyojana_tax'], 2) . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">नोटीस फी </td>
                        <td>' . number_format($receipt['previous_vasul_dand_tax'], 2) . '</td>
                        <td>' . number_format($receipt['current_vasul_dand_tax'], 2) . '</td>
                        <td>' . number_format($receipt['previous_vasul_dand_tax'] + $receipt['current_vasul_dand_tax'], 2) . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">इतर</td>
                        <td>' . number_format($receipt['previous_vasul_padsar_tax'], 2) . '</td>
                        <td>' . number_format($receipt['current_vasul_padsar_tax'], 2) . '</td>
                        <td>' . number_format($receipt['previous_vasul_padsar_tax'] + $receipt['current_vasul_padsar_tax'], 2) . '</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">एकूण</th>
                        <th>' . number_format($total_previous, 2) . '</th>
                        <th>' . number_format($total_current, 2) . '</th>
                        <th>' . number_format($total_amount, 2) . '</th>
                    </tr>
                </tbody>
            </table>
            <table class="info-table">
                <tr>
                    <td style="text-align:left;"><strong> अक्षरी रक्कम रुपये </strong>' . numberToWords($total_amount) . '</td>
                    <td></td>
                    <td></td>
                    <td><strong> मिळाले. </strong></td>
                </tr>
            </table>
            <div class="footer" style="margin-top: 10px;">
                <div>दिनांक : ' . date('d/m/Y', strtotime($receipt['vasul_dinank'])) . '</div>
                <div>वसूल करणाऱ्याची सही व नाव .</div>
            </div>
        </div>
    </body>
    </html>';
}

// Helper function to convert numbers to words in Marathi


function numberToMarathiWords($number)
{
    $units = [
        0 => 'शून्य',
        1 => 'एक',
        2 => 'दोन',
        3 => 'तीन',
        4 => 'चार',
        5 => 'पाच',
        6 => 'सहा',
        7 => 'सात',
        8 => 'आठ',
        9 => 'नऊ',
        10 => 'दहा',
        11 => 'अकरा',
        12 => 'बारा',
        13 => 'तेरा',
        14 => 'चौदा',
        15 => 'पंधरा',
        16 => 'सोळा',
        17 => 'सतरा',
        18 => 'अठरा',
        19 => 'एकोणीस'
    ];

    $tens = [
        20 => 'वीस',
        30 => 'तीस',
        40 => 'चाळीस',
        50 => 'पन्नास',
        60 => 'साठ',
        70 => 'सत्तर',
        80 => 'ऐंशी',
        90 => 'नव्वद'
    ];

    if ($number < 20) {
        return $units[$number];
    } elseif ($number < 100) {
        $ten = intval($number / 10) * 10;
        $unit = $number % 10;
        return $tens[$ten] . ($unit ? ' ' . $units[$unit] : '');
    } elseif ($number < 1000) {
        $hundreds = intval($number / 100);
        $remainder = $number % 100;
        return $units[$hundreds] . ' शंभर' . ($remainder ? ' ' . numberToMarathiWords($remainder) : '');
    } elseif ($number < 100000) {
        $thousands = intval($number / 1000);
        $remainder = $number % 1000;
        return numberToMarathiWords($thousands) . ' हजार' . ($remainder ? ' ' . numberToMarathiWords($remainder) : '');
    } elseif ($number < 10000000) {
        $lakhs = intval($number / 100000);
        $remainder = $number % 100000;
        return numberToMarathiWords($lakhs) . ' लाख' . ($remainder ? ' ' . numberToMarathiWords($remainder) : '');
    } else {
        return 'मर्यादा ओलांडली'; // Limit exceeded
    }
}



function numberToWords($number)
{
    // This is a simplified version - you may want to implement a full number to words converter
    // $formatter = new NumberFormatter('mr', NumberFormatter::SPELLOUT);
    // return $formatter->format($number);
    return numberToMarathiWords($number);
}
$html = <<<HTML
         $html 
HTML;
echo $html;
?>