<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

// Get parameters from URL
$financial_year = $_GET['financial_year'] ?? '';
$revenue_village = $_GET['revenue_village'] ?? '';
$ward = $_GET['ward'] ?? '';
$malmatta_id = $_GET['malmatta_id'] ?? '';
$bill_area = $_GET['bill_area'] ?? 'gramnidhi';
$bill_type = $_GET['bill_type'] ?? 'complete';
$date = $_GET['date'] ?? date('Y-m-d');
// Fetch data based on parameters
$taxDemands = $fun->getTaxDemandsWithFilters($revenue_village, $financial_year, $ward, $malmatta_id);
// print_r($taxDemands);
$taxReportsArray = array();
if (mysqli_num_rows($taxDemands) == 0) {
    echo "<script>alert('No data found for the given filters.');</script>";
    exit;
} else {
    while ($row = mysqli_fetch_assoc($taxDemands)) {
        $taxReportsArray[] = $row;
        // print_r($row);
    }
}

// print_r($taxReportsArray);




$locationData = $fun->getLgdTableWithVillageCode($_SESSION['village_code']);
$locationData = mysqli_fetch_assoc($locationData);
// Generate a bill number
$bill_no = "BILL-" . date('Ymd') . "-" . rand(1000, 9999);
$document_totatls = array(
    "previous_building_tax" => 0,
    "current_building_tax" => 0,
    "total_building_tax" => 0,
    "previous_light_tax" => 0,
    "current_light_tax" => 0,
    "total_light_tax" => 0,
    "previous_health_tax" => 0,
    "current_health_tax" => 0,
    "total_health_tax" => 0,
    "previous_water_tax" => 0,
    "current_water_tax" => 0,
    "total_water_tax" => 0,
    "previous_padsar_tax" => 0,
    "current_padsar_tax" => 0,
    "total_padsar_tax" => 0,
    "previous_fine_tax" => 0,
    "current_fine_tax" => 0,
    "total_fine_tax" => 0,
    "total_previous_amount" => 0,
    "total_current_amount" => 0,
    "total_amount" => 0,
);
$html = "";
// Prepare HTML content
foreach ($taxReportsArray as $report) {
    $owner_name = $report['owner_name'];
    $occupant_name = $report['occupant_name'];
    $financial_year = $report['financial_year'];
    $ward_name = $report['ward_name'];
    $bill_no = $report['bill_no'];
    $malmatta_no = $report['malmatta_no'];
    $previous_building_tax = $report['previous_building_tax'];
    $current_building_tax = $report['current_building_tax'];
    $total_building_tax = $report['total_building_tax'];
    $previous_light_tax = $report['previous_light_tax'];
    $current_light_tax = $report['current_light_tax'];
    $total_light_tax = $report['total_light_tax'];
    $previous_health_tax = $report['previous_health_tax'];
    $current_health_tax = $report['current_health_tax'];
    $total_health_tax = $report['total_health_tax'];
    $previous_water_tax = $report['previous_water_tax'];
    $current_water_tax = $report['current_water_tax'];
    $total_water_tax = $report['total_water_tax'];
    $previous_padsar_tax = $report['previous_padsar_tax'];
    $current_padsar_tax = $report['current_padsar_tax'];
    $total_padsar_tax = $report['total_padsar_tax'];
    $previous_fine_tax = $report['previous_fine_tax'];
    $current_fine_tax = $report['current_fine_tax'];
    $total_fine_tax = $report['total_fine_tax'];
    $total_previous_amount = $report['total_previous_amount'];
    $total_current_amount = $report['total_current_amount'];
    $total_amount = $report['total_amount'];
    $bill_date = $report['bill_date'];

    // Update document totals
    $document_totatls['previous_building_tax'] += $previous_building_tax;
    $document_totatls['current_building_tax'] += $current_building_tax;
    $document_totatls['total_building_tax'] += $total_building_tax;
    $document_totatls['previous_light_tax'] += $previous_light_tax;
    $document_totatls['current_light_tax'] += $current_light_tax;
    $document_totatls['total_light_tax'] += $total_light_tax;
    $document_totatls['previous_health_tax'] += $previous_health_tax;
    $document_totatls['current_health_tax'] += $current_health_tax;
    $document_totatls['total_health_tax'] += $total_health_tax;
    $document_totatls['previous_water_tax'] += $previous_water_tax;
    $document_totatls['current_water_tax'] += $current_water_tax;
    $document_totatls['total_water_tax'] += $total_water_tax;
    $document_totatls['previous_padsar_tax'] += $previous_padsar_tax;
    $document_totatls['current_padsar_tax'] += $current_padsar_tax;
    $document_totatls['total_padsar_tax'] += $total_padsar_tax;
    $document_totatls['previous_fine_tax'] += $previous_fine_tax;
    $document_totatls['current_fine_tax'] += $current_fine_tax;
    $document_totatls['total_fine_tax'] += $total_fine_tax;
    $document_totatls['total_previous_amount'] += $total_previous_amount;
    $document_totatls['total_current_amount'] += $total_current_amount;
    $document_totatls['total_amount'] += $total_amount;
    $html .= <<<HTML
<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>करांची मागणी पावती</title>
    <style>
        body { font-family: 'Noto Sans Devanagari', sans-serif; margin: 20px; }
        .receipt-box { border: 2px solid black; padding: 20px; max-width: 80%; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 18px; }
        caption { caption-side: top; font-weight: bold; margin-bottom: 10px; }
        th, td { border: 1px solid black; padding: 6px; text-align: center; }
        .header { text-align: center; font-weight: bold; margin-bottom: 10px; font-size: 20px; }
        .info-table td { border: none; padding: 5px; text-align: left; }
        .section { margin-top: 20px; }
        .footer-table { width: 100%; border: 1px solid black; margin-top: 30px; }
        .footer-table td { vertical-align: top; border: 1px solid black; padding: 10px; }
        .footer-table .full { padding: 10px; text-align: left; }
        .dashed-border { border-top: 2px dashed black; margin-top: 20px; }
        @media print {
            @page { size: A4; margin: 0; }
            body { margin: 1.6cm; }
        }
         table {
        page-break-inside: avoid;
    }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="header">
            नमुना ९ (क) नियम ३२(५) पाहा<br>
            करांची मागणी पावती
        </div>

        <p>श्री. {$owner_name} यांच्याकडून पुढील करांची रक्कम वसुलीयोग्य आहे.</p>

        <table class="info-table">
            <tr>
                <td><strong>आर्थिक वर्ष :</strong> {$financial_year}</td>
                <td><strong>वॉर्ड :</strong> {$ward_name}</td>
                <td><strong>तालुका :</strong> {$locationData['Development_Block_Name']}</td>
            </tr>
            <tr>
                <td><strong>ग्रामपंचायत :</strong> {$locationData['Village_Panchayat_Name_TLB_Name']}</td>
                <td><strong>जिल्हा :</strong> {$locationData['District_Name']}</td>
                <td><strong>मिळकत क्रमांक:</strong> {$malmatta_no}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>बिल नंबर:</strong> {$bill_no}</td>
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
                    <td style="text-align: left;">(१)घरपट्टी/खुली जागा/इतर</td>
                    <td>{$previous_building_tax}</td>
                    <td>{$current_building_tax}</td>
                    <td>{$total_building_tax}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(२)दिवाबत्ती कर</td>
                    <td>{$previous_light_tax}</td>
                    <td>{$current_light_tax}</td>
                    <td>{$total_light_tax}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(३)आरोग्य कर</td>
                    <td>{$previous_health_tax}</td>
                    <td>{$current_health_tax}</td>
                    <td>{$total_health_tax}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(४)सामान्य पाणीपट्टी कर</td>
                    <td>{$previous_water_tax}</td>
                    <td>{$current_water_tax}</td>
                    <td>{$total_water_tax}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(५)खुली जागा/इतर</td>
                    <td>{$previous_padsar_tax}</td>
                    <td>{$current_padsar_tax}</td>
                    <td>{$total_padsar_tax}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(६)दंड रक्कम</td>
                    <td>{$previous_fine_tax}</td>
                    <td>{$current_fine_tax}</td>
                    <td>{$total_fine_tax}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(७)वॉरंट फी</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <th style="text-align: left;">एकूण</th>
                    <th>{$total_previous_amount}</th>
                    <th>{$total_current_amount}</th>
                    <th>{$total_amount}</th>
                </tr>
            </tbody>
        </table>

        <table class="footer-table">
            <tr>
                <td colspan="4" style=" text-align:left;">दिनांक व वेळ : {$bill_date} </td>
            </tr>
            <tr>
                <td colspan="2" style="border:2px solid black; height: 10px;text-align: left;color: red; font-weight: bolder;">
                    X
                </td>
                <td colspan="2" style="border:2px solid black; height: 10px;text-align: left;color: red; font-weight: bolder;">
                    X
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; padding:2px; text-align: left;vertical-align: bottom;border-bottom: none;border-right: none;">
                    <strong>ग्रामसेवक / ग्रामविकास अधिकारी</strong>
                </td>
                <td colspan="2" style="width: 50%; padding:2px; text-align: left;vertical-align: bottom;border-bottom: none;border-left: none;">
                    <strong>सरपंच</strong>
                </td>
            </tr>
            <tr>
                <td colspan="4" style=" font-size:14px; text-align:left;border-top: none;">
                    १) हे बिल आपल्यास प्राप्त झाल्यापासून देय रकमेचा भरणा १५ दिवसांचे आत करावा.
                    अन्यथा ग्रामपंचायत अधिनियमाच्या कलम क्र. ११९(२) <br>अन्वये आपल्यावर मागणी बजावण्यात येईल.
                    २) ३१/०३/२०२४ पूर्वी कर न भरल्यास घरपट्टी थकबाकीवर ५०% दंड आकारण्यात येईल.<br>
                    ३) ३० सप्टेंबर पर्यंत सूट देऊन {  }{रक्कम} रकमेचा भरणा कराचा आहे.
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:left;" class="">
                    <strong>टीप :(१) या पावतीचा नमुना कार्बन प्रतीलीपी असावा.<br> (२) नमुने देण्यात येतील तेव्हा त्यावर पुस्तकांचे क्रमांक छापलेले असावे.</strong>
                </td>
                <td colspan="1" style="border:2px solid black;"></td>
            </tr>
        </table>

        <div class="dashed-border"></div>
        <div style="page-break-after: always;"></div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
HTML;

}

$html .= <<<HTML
<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>करांची मागणी पावती</title>
    <style>
        body { font-family: 'Noto Sans Devanagari', sans-serif; margin: 20px; }
        .receipt-box { border: 2px solid black; padding: 20px; max-width: 80%; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 18px; }
        caption { caption-side: top; font-weight: bold; margin-bottom: 10px; }
        th, td { border: 1px solid black; padding: 6px; text-align: center; }
        .header { text-align: center; font-weight: bold; margin-bottom: 10px; font-size: 20px; }
        .info-table td { border: none; padding: 5px; text-align: left; }
        .section { margin-top: 20px; }
        .footer-table { width: 100%; border: 1px solid black; margin-top: 30px; }
        .footer-table td { vertical-align: top; border: 1px solid black; padding: 10px; }
        .footer-table .full { padding: 10px; text-align: left; }
        .dashed-border { border-top: 2px dashed black; margin-top: 20px; }
        @media print {
            @page { size: A4; margin: 0; }
            body { margin: 1.6cm; }
        }
         table {
        page-break-inside: avoid;
    }
    </style>
</head>
<body>
    <div class="receipt-box">
        
        

        <div class="dashed-border"></div>
        <table>
            <caption>थकबाकी यादी - {$locationData['Village_Panchayat_Name_TLB_Name']}, तालुका {$locationData['Development_Block_Name']}, जिल्हा {$locationData['District_Name']}</caption>
            <thead>
                <tr>
                    <th colspan="2">एकूण कर मागणी बिल संख्या </th>
                    <th colspan="2">1 </th>
                </tr>
                <tr>
                    <th></th>
                    <th>एकूण मागील </th>
                    <th>एकूण चालू </th>
                    <th>एकूण </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">(१)घरपट्टी/खुली जागा/इतर </td>
                    <td>{$document_totatls['previous_building_tax']}</td>
                    <td>{$document_totatls['current_building_tax']}</td>
                    <td>{$document_totatls['total_building_tax']}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(२)दिवाबत्ती कर </td>
                    <td>{$document_totatls['previous_light_tax']}</td>
                    <td>{$document_totatls['current_light_tax']}</td>
                    <td>{$document_totatls['total_light_tax']}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(३)आरोग्य कर</td>
                    <td>{$document_totatls['previous_health_tax']}</td>
                    <td>{$document_totatls['current_health_tax']}</td>
                    <td>{$document_totatls['total_health_tax']}</td>
                </tr>
                <tr>
                    <td style="text-align: left;"> (४)सामान्य पाणीपट्टी कर </td>
                    <td>{$document_totatls['previous_water_tax']}</td>
                    <td>{$document_totatls['current_water_tax']}</td>
                    <td>{$document_totatls['total_water_tax']}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(५)खुली जागा/इतर </td>
                    <td>{$document_totatls['previous_padsar_tax']}</td>
                    <td>{$document_totatls['current_padsar_tax']}</td>
                    <td>{$document_totatls['total_padsar_tax']}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(६)दंड रक्कम </td>
                    <td>{$document_totatls['previous_fine_tax']}</td>
                    <td>{$document_totatls['current_fine_tax']}</td>
                    <td>{$document_totatls['total_fine_tax']}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">(७)वॉरंट फी </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <th style="text-align: left;">एकूण </th>
                    <th>{$document_totatls['total_previous_amount']}</th>
                    <th>{$document_totatls['total_current_amount']}</th>
                    <th>{$document_totatls['total_amount']}</th>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
HTML;


echo $html;
?>