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
$road = $_GET['road'] ?? '';
$date = $_GET['date'] ?? date('Y-m-d');
// Fetch data based on parameters
$taxDemands = $fun->getTaxDemandsWithFilters($revenue_village, $financial_year, $ward, $malmatta_id, $road);
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

$sr = 0;
$date = date('d-m-Y');
$html = <<<HTML
<!DOCTYPE html>
<html lang="mr">

<head>
    <meta charset="UTF-8">
    <title>करांची मागणी पावती</title>
    <style>
        body {
            font-family: 'Noto Sans Devanagari', 'Devanagari', sans-serif;
            padding: 30px;
            line-height: 1.6;
            max-width: 80%;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        .no-border td {
            border: none;
            padding: 4px 10px;
        }

        .center {
            text-align: center;
            font-weight: bold;
        }

        .note {
            margin-top: 20px;
            font-size: 14px;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="center">
        नमुना ९ <br>
        थकबाकी यादी
    </div>
        


    <table>
        <thead>
            <tr>
                <th>अ.क्र.</th>
                <th>मिळकत क्रमांक</th>
                <th>मिळकत धरकचे नाव </th>
                <th>रक्कम</th>
            </tr>

        </thead>
        <tbody>
HTML;
foreach ($taxReportsArray as $report) {
    $owner_name = $report['owner_name'];
    $sr++;
    $malmatta_no = $report['malmatta_no'];

    $total_amount = $report['total_amount'];
    $bill_date = $report['bill_date'];


    $document_totatls['total_amount'] += $total_amount;
    $html .= <<<HTML

            <tr>
                <td>{$sr}</td>
                <td> {$malmatta_no}</td>
                <td> {$owner_name}</td>
                <td>{$total_amount}</td>
                

            </tr>
           
HTML;

}
$html .= <<<HTML
     <tr>
                <td>एकूण</td>
                <td></td>
                <td></td>
                <td>{$document_totatls['total_amount']}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>दिनांक : {$date}</div>
        <div>सचिव/वसुली लिपिकाची सही.</div>
    </div>
    

</body>

</html>
HTML;

echo $html;
?>