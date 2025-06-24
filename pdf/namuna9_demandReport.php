<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

// Get filter parameters
$criteria = $_GET['criteria'] ?? 'all_register';
$financial_year = $_GET['financial_year'] ?? '';
$village_code = $_GET['revenue_village'] ?? '';
$ward = $_GET['ward'] ?? '';
$malmatta_id = $_GET['malmatta_id'] ?? '';


$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

// Get data based on criteria
if ($criteria === 'all_register') {
    $data = $fun->getKarvasuliReportNamuna9($financial_year);
} elseif ($criteria === 'gava_mangani') {
    $data = $fun->getKarvasuliReportNamuna9($financial_year, $village_code);
} elseif ($criteria === 'malmatta_mangani') {
    $data = $fun->getKarvasuliReportNamuna9($financial_year, null, $ward, $malmatta_id);
}
// Initialize totals
$total_previous_mangani = 0;
$total_current_mangani = 0;
$total_previous_vasul = 0;
$total_current_vasul = 0;
$total_balance = 0;
// Calculate totals if data exists
if (!empty($data)) {
    foreach ($data as $row) {
        $total_previous_mangani += $row['previous_mangani_total_tax'] ?? 0;
        $total_current_mangani += $row['current_mangani_total_tax'] ?? 0;
        $total_previous_vasul += $row['previous_vasul_total_tax'] ?? 0;
        $total_current_vasul += $row['current_vasul_total_tax'] ?? 0;
        $total_balance += (($row['previous_mangani_total_tax'] ?? 0) + ($row['current_mangani_total_tax'] ?? 0)) -
            (($row['previous_vasul_total_tax'] ?? 0) + ($row['current_vasul_total_tax'] ?? 0));
    }

}
$rawResult = $data; // assuming $result is your mysqli_result
$result = [];

foreach ($rawResult as $row) {
    $result[] = $row;
}


$locationData = $fun->getLgdTableWithVillageCode($_SESSION['village_code']);
$locationData = mysqli_fetch_assoc($locationData);

// Generate HTML
ob_start();
?>
<!DOCTYPE html>
<html lang="mr">

<head>
    <meta charset="UTF-8">
    <title>वार्षिक कर मागणी व वसुली यादी</title>
    <style>
        body {
            font-family: 'Mangal', 'Arial Unicode MS', sans-serif;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        caption {
            caption-side: top;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(360deg);
            white-space: nowrap;
        }

        .filter-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }


        .text-center {
            text-align: center;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .data-row td {
            font-size: 8px;
        }

        .flex {
            display: flex;
            justify-content: start;
            gap: 5px;
        }

        .flex-row {
            display: flex;
            flex-direction: row;
        }

        .flex-column {
            display: flex;
            flex-direction: column;
        }

        .justify-between {
            justify-content: space-between;
        }

        p {
            font-size: 10px;
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="text-center">
        <h2 class="text-center">नमुना क्रमांक ९</h2>
        <p>[नियम २२ (९),३२ (४), ५ (६) व (७) पहा]</p>
        <p>सन <?php echo $financial_year; ?> या वर्षाची आकारणी केलेल्या करांची मागणी नोंदवही</p>
        <div class="flex justify-between">
            <p>ग्रामपंचायत: <?php echo htmlspecialchars($locationData["Village_Panchayat_Name_TLB_Name"]); ?>
            </p>
            <p>तालुकाः <?php echo htmlspecialchars($locationData['Development_Block_Name']); ?> </p>
            <p>जिल्हा: <?php echo htmlspecialchars($locationData['District_Name']); ?> </p>
            <?php if ($ward != "निवडा" && $ward): ?>
                <p>वॉर्ड क्रमांक: <?php echo htmlspecialchars($ward); ?></p>

            <?php endif; ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" colspan="2">अ.क्र.</th>
                <th rowspan="2" colspan="2">आर्थिक वर्ष </th>
                <th rowspan="2" colspan="2">मि. क्र. </th>
                <th rowspan="2" colspan="3" class="vertical-text">वार्ड क्र.</th>
                <th rowspan="2" colspan="4">मालमत्ता धारकाचे नाव </th>
                <th rowspan="2" colspan="6">कर देणाऱ्याचे नाव </th>

                <th colspan="10">मागणी </th>
                <th colspan="2" rowspan="2">बुक क्र. <br>पावती क्र. <br>पावती दिनांक </th>
                <th colspan="11">वसूल</th>
                <th rowspan="2">बाकी </th>

            </tr>
            <tr>
                <th>घरपट्टी कर </th>
                <th>आरोग्य कर </th>
                <th>दिवाबत्ती कर</th>
                <th>सफाई कर</th>
                <th>पाणीपट्टी कर</th>
                <th>पडसर जमीन </th>
                <th>दंड</th>
                <th>नोटीस फी </th>
                <th colspan="2">एकूण मागणी </th>
                <th>घरपट्टी कर </th>
                <th>आरोग्य कर </th>
                
                <th>दिवाबत्ती कर</th>
                <th>सफाई कर</th>
                <th>पाणीपट्टी कर</th>
                <th>पडसर जमीन </th>
                <th>दंड</th>
                <th>नोटीस फी </th>
                <th>सूट </th>
                <th colspan="2">एकूण वसूल</th>

            </tr>

        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php $i = 1;
                // Initialize detailed totals
                $totals = [
                    'prev_mangani' => [
                        'building' => 0,
                        'health' => 0,
                        'light' => 0,
                        'safai' => 0,
                        'water' => 0,
                        'padsar' => 0,
                        'fine' => 0,
                        'notice' => 0,
                        'total' => 0
                    ],
                    'curr_mangani' => [
                        'building' => 0,
                        'health' => 0,
                        'light' => 0,
                        'safai' => 0,
                        'water' => 0,
                        'padsar' => 0,
                        'fine' => 0,
                        'notice' => 0,
                        'total' => 0
                    ],
                    'prev_vasul' => [
                        'building' => 0,
                        'health' => 0,
                        'light' => 0,
                        'safai' => 0,
                        'water' => 0,
                        'padsar' => 0,
                        'fine' => 0,
                        'notice' => 0,
                        'discount' => 0,
                        'total' => 0
                    ],
                    'curr_vasul' => [
                        'building' => 0,
                        'health' => 0,
                        'safai' => 0,
                        'light' => 0,
                        'water' => 0,
                        'padsar' => 0,
                        'fine' => 0,
                        'notice' => 0,
                        'discount' => 0,
                        'total' => 0
                    ]
                ];
                ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td rowspan="3" colspan="2"><?= $i++ ?></td>
                        <td rowspan="3" colspan="2"><?= htmlspecialchars($financial_year) ?></td>
                        <td rowspan="3" colspan="2"><?= htmlspecialchars($row['malmatta_no'] ?? '') ?></td>
                        <td rowspan="3" colspan="3" class="vertical-text"><?= htmlspecialchars($row['ward_name'] ?? '') ?></td>
                        <td rowspan="3" colspan="4"><?= htmlspecialchars($row['owner_name'] ?? '') ?></td>
                        <td rowspan="3" colspan="4"><?= htmlspecialchars($row['occupant_name'] ?? '') ?></td>

                        <!-- Previous Demand -->
                        <td colspan="2">मागील:</td>
                        <td><?= htmlspecialchars($row['previous_mangani_building_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_mangani_health_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_mangani_divabatti_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_mangani_safai_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_mangani_panniyojana_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_mangani_padsar_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_mangani_dand_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_mangani_notice_fee'] ?? 0) ?></td>
                        <td colspan="2"><?= htmlspecialchars($row['previous_mangani_total_tax'] ?? 0) ?></td>

                        <td colspan="2" rowspan="3">
                            <?= htmlspecialchars($row['pustak_kramanak'] ?? '') ?><br>
                            <?= htmlspecialchars($row['pavati_kramanak'] ?? '') ?><br>
                            <?= !empty($row['vasul_dinank']) ? date('d-m-Y', strtotime($row['vasul_dinank'])) : '' ?>
                        </td>

                        <!-- Previous Collection -->
                        <td><?= htmlspecialchars($row['previous_vasul_building_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_health_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_divabatti_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_safai_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_panniyojana_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_padsar_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_dand_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_notice_fee'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['previous_vasul_sut_tax'] ?? 0) ?></td>
                        <td colspan="2"><?= htmlspecialchars($row['previous_vasul_total_tax'] ?? 0) ?></td>

                        <td rowspan="3">
                            <?= htmlspecialchars(($row['total_mangani_tax'] ?? 0) - ($row['total_vasul_tax'] ?? 0)) ?>
                        </td>
                    </tr>

                    <!-- Current Demand -->
                    <tr>
                        <td colspan="2">चालू:</td>
                        <td><?= htmlspecialchars($row['current_mangani_building_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_mangani_health_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_mangani_divabatti_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_mangani_safai_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_mangani_panniyojana_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_mangani_padsar_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_mangani_dand_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_mangani_notice_fee'] ?? 0) ?></td>
                        <td colspan="2"><?= htmlspecialchars($row['current_mangani_total_tax'] ?? 0) ?></td>

                        <!-- Current Collection -->
                        <td><?= htmlspecialchars($row['current_vasul_building_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_health_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_divabatti_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_safai_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_panniyojana_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_padsar_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_dand_tax'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_notice_fee'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($row['current_vasul_sut_tax'] ?? 0) ?></td>
                        <td colspan="2"><?= htmlspecialchars($row['current_vasul_total_tax'] ?? 0) ?></td>
                    </tr>

                    <!-- Total -->
                    <tr>
                        <td colspan="2">एकूण:</td>
                        <td><?= htmlspecialchars(($row['previous_mangani_building_tax'] ?? 0) + ($row['current_mangani_building_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_mangani_health_tax'] ?? 0) + ($row['current_mangani_health_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_mangani_divabatti_tax'] ?? 0) + ($row['current_mangani_divabatti_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_mangani_safai_tax'] ?? 0) + ($row['current_mangani_safai_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_mangani_panniyojana_tax'] ?? 0) + ($row['current_mangani_panniyojana_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_mangani_padsar_tax'] ?? 0) + ($row['current_mangani_padsar_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_mangani_dand_tax'] ?? 0) + ($row['current_mangani_dand_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_mangani_notice_fee'] ?? 0) + ($row['current_mangani_notice_fee'] ?? 0)) ?>
                        </td>
                        <td colspan="2">
                            <?= htmlspecialchars(($row['previous_mangani_total_tax'] ?? 0) + ($row['current_mangani_total_tax'] ?? 0)) ?>
                        </td>

                        <td><?= htmlspecialchars(($row['previous_vasul_building_tax'] ?? 0) + ($row['current_vasul_building_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_vasul_health_tax'] ?? 0) + ($row['current_vasul_health_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_vasul_divabatti_tax'] ?? 0) + ($row['current_vasul_divabatti_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_vasul_safai_tax'] ?? 0) + ($row['current_vasul_safai_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_vasul_panniyojana_tax'] ?? 0) + ($row['current_vasul_panniyojana_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_vasul_padsar_tax'] ?? 0) + ($row['current_vasul_padsar_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_vasul_dand_tax'] ?? 0) + ($row['current_vasul_dand_tax'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['previous_vasul_notice_fee'] ?? 0) + ($row['current_vasul_notice_fee'] ?? 0)) ?>
                        </td>
                        <td><?= htmlspecialchars(($row['total_sut_tax'] ?? 0)) ?></td>
                        <td colspan="2">
                            <?= htmlspecialchars(($row['previous_vasul_total_tax'] ?? 0) + ($row['current_vasul_total_tax'] ?? 0)) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="34" class="text-center">कोणतेही डेटा सापडले नाही</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Summary Table -->
    <table>
        <thead>
            <tr>

                <th rowspan="2">खात्याचे नाव </th>
                <th colspan="3">मागणी </th>
                <th colspan="3">वसूल</th>
                <th colspan="3">येणे बाकी </th>

            </tr>
            <tr>
                <th>मागील एकूण रुपये </th>
                <th>चालू एकूण रुपये </th>
                <th>एकूण रुपये </th>
                <th>मागील एकूण रुपये </th>
                <th>चालू एकूण रुपये </th>
                <th>एकूण रुपये </th>
                <th>मागील एकूण रुपये </th>
                <th>चालू एकूण रुपये </th>
                <th>एकूण रुपये </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php
                // Calculate totals
                $totals = [
                    'building' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'health' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'safai' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'light' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'water' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'padsar' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'fine' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'notice' => ['prev_demand' => 0, 'curr_demand' => 0, 'prev_collect' => 0, 'curr_collect' => 0],
                    'discount' => ['prev_collect' => 0, 'curr_collect' => 0],
                ];

                foreach ($data as $row) {
                    $totals['building']['prev_demand'] += $row['previous_mangani_building_tax'] ?? 0;
                    $totals['building']['curr_demand'] += $row['current_mangani_building_tax'] ?? 0;
                    $totals['building']['prev_collect'] += $row['previous_vasul_building_tax'] ?? 0;
                    $totals['building']['curr_collect'] += $row['current_vasul_building_tax'] ?? 0;

                    $totals['health']['prev_demand'] += $row['previous_mangani_health_tax'] ?? 0;
                    $totals['health']['curr_demand'] += $row['current_mangani_health_tax'] ?? 0;
                    $totals['health']['prev_collect'] += $row['previous_vasul_health_tax'] ?? 0;
                    $totals['health']['curr_collect'] += $row['current_vasul_health_tax'] ?? 0;

                    $totals['safai']['prev_demand'] += $row['previous_mangani_safai_tax'] ?? 0;
                    $totals['safai']['curr_demand'] += $row['current_mangani_safai_tax'] ?? 0;
                    $totals['safai']['prev_collect'] += $row['previous_vasul_safai_tax'] ?? 0;
                    $totals['safai']['curr_collect'] += $row['current_vasul_safai_tax'] ?? 0;

                    $totals['light']['prev_demand'] += $row['previous_mangani_divabatti_tax'] ?? 0;
                    $totals['light']['curr_demand'] += $row['current_mangani_divabatti_tax'] ?? 0;
                    $totals['light']['prev_collect'] += $row['previous_vasul_divabatti_tax'] ?? 0;
                    $totals['light']['curr_collect'] += $row['current_vasul_divabatti_tax'] ?? 0;

                    $totals['water']['prev_demand'] += $row['previous_mangani_panniyojana_tax'] ?? 0;
                    $totals['water']['curr_demand'] += $row['current_mangani_panniyojana_tax'] ?? 0;
                    $totals['water']['prev_collect'] += $row['previous_vasul_panniyojana_tax'] ?? 0;
                    $totals['water']['curr_collect'] += $row['current_vasul_panniyojana_tax'] ?? 0;

                    $totals['padsar']['prev_demand'] += $row['previous_mangani_padsar_tax'] ?? 0;
                    $totals['padsar']['curr_demand'] += $row['current_mangani_padsar_tax'] ?? 0;
                    $totals['padsar']['prev_collect'] += $row['previous_vasul_padsar_tax'] ?? 0;
                    $totals['padsar']['curr_collect'] += $row['current_vasul_padsar_tax'] ?? 0;

                    $totals['fine']['prev_demand'] += $row['previous_mangani_dand_tax'] ?? 0;
                    $totals['fine']['curr_demand'] += $row['current_mangani_dand_tax'] ?? 0;
                    $totals['fine']['prev_collect'] += $row['previous_vasul_dand_tax'] ?? 0;
                    $totals['fine']['curr_collect'] += $row['current_vasul_dand_tax'] ?? 0;

                    $totals['notice']['prev_demand'] += $row['previous_mangani_notice_fee'] ?? 0;
                    $totals['notice']['curr_demand'] += $row['current_mangani_notice_fee'] ?? 0;
                    $totals['notice']['prev_collect'] += $row['previous_vasul_notice_fee'] ?? 0;
                    $totals['notice']['curr_collect'] += $row['current_vasul_notice_fee'] ?? 0;

                    $totals['discount']['prev_collect'] += $row['previous_vasul_sut_tax'] ?? 0;
                    $totals['discount']['curr_collect'] += $row['current_vasul_sut_tax'] ?? 0;
                }

                $grand_totals = [
                    'prev_demand' => 0,
                    'curr_demand' => 0,
                    'prev_collect' => 0,
                    'curr_collect' => 0,
                    'prev_balance' => 0,
                    'curr_balance' => 0
                ];

                foreach ($totals as $type => $values) {
                    $grand_totals['prev_demand'] += $values['prev_demand'] ?? 0;
                    $grand_totals['curr_demand'] += $values['curr_demand'] ?? 0;
                    $grand_totals['prev_collect'] += $values['prev_collect'] ?? 0;
                    $grand_totals['curr_collect'] += $values['curr_collect'] ?? 0;
                }

                $grand_totals['prev_balance'] = $grand_totals['prev_demand'] - $grand_totals['prev_collect'];
                $grand_totals['curr_balance'] = $grand_totals['curr_demand'] - $grand_totals['curr_collect'];
                ?>

                <!-- Building Tax -->
                <tr>
                    <td>घरपट्टी कर</td>
                    <td><?= $totals['building']['prev_demand'] ?></td>
                    <td><?= $totals['building']['curr_demand'] ?></td>
                    <td><?= $totals['building']['prev_demand'] + $totals['building']['curr_demand'] ?></td>
                    <td><?= $totals['building']['prev_collect'] ?></td>
                    <td><?= $totals['building']['curr_collect'] ?></td>
                    <td><?= $totals['building']['prev_collect'] + $totals['building']['curr_collect'] ?></td>
                    <td><?= $totals['building']['prev_demand'] - $totals['building']['prev_collect'] ?></td>
                    <td><?= $totals['building']['curr_demand'] - $totals['building']['curr_collect'] ?></td>
                    <td><?= ($totals['building']['prev_demand'] + $totals['building']['curr_demand']) - ($totals['building']['prev_collect'] + $totals['building']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Health Tax -->
                <tr>
                    <td>आरोग्य कर</td>
                    <td><?= $totals['health']['prev_demand'] ?></td>
                    <td><?= $totals['health']['curr_demand'] ?></td>
                    <td><?= $totals['health']['prev_demand'] + $totals['health']['curr_demand'] ?></td>
                    <td><?= $totals['health']['prev_collect'] ?></td>
                    <td><?= $totals['health']['curr_collect'] ?></td>
                    <td><?= $totals['health']['prev_collect'] + $totals['health']['curr_collect'] ?></td>
                    <td><?= $totals['health']['prev_demand'] - $totals['health']['prev_collect'] ?></td>
                    <td><?= $totals['health']['curr_demand'] - $totals['health']['curr_collect'] ?></td>
                    <td><?= ($totals['health']['prev_demand'] + $totals['health']['curr_demand']) - ($totals['health']['prev_collect'] + $totals['health']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Lighting Tax -->
                <tr>
                    <td>दिवाबत्ती कर</td>
                    <td><?= $totals['light']['prev_demand'] ?></td>
                    <td><?= $totals['light']['curr_demand'] ?></td>
                    <td><?= $totals['light']['prev_demand'] + $totals['light']['curr_demand'] ?></td>
                    <td><?= $totals['light']['prev_collect'] ?></td>
                    <td><?= $totals['light']['curr_collect'] ?></td>
                    <td><?= $totals['light']['prev_collect'] + $totals['light']['curr_collect'] ?></td>
                    <td><?= $totals['light']['prev_demand'] - $totals['light']['prev_collect'] ?></td>
                    <td><?= $totals['light']['curr_demand'] - $totals['light']['curr_collect'] ?></td>
                    <td><?= ($totals['light']['prev_demand'] + $totals['light']['curr_demand']) - ($totals['light']['prev_collect'] + $totals['light']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Safai Tax -->
                <tr>
                    <td>सफाई कर</td>
                    <td><?= $totals['safai']['prev_demand'] ?></td>
                    <td><?= $totals['safai']['curr_demand'] ?></td>
                    <td><?= $totals['safai']['prev_demand'] + $totals['safai']['curr_demand'] ?></td>
                    <td><?= $totals['safai']['prev_collect'] ?></td>
                    <td><?= $totals['safai']['curr_collect'] ?></td>
                    <td><?= $totals['safai']['prev_collect'] + $totals['safai']['curr_collect'] ?></td>
                    <td><?= $totals['safai']['prev_demand'] - $totals['safai']['prev_collect'] ?></td>
                    <td><?= $totals['safai']['curr_demand'] - $totals['safai']['curr_collect'] ?></td>
                    <td><?= ($totals['safai']['prev_demand'] + $totals['safai']['curr_demand']) - ($totals['safai']['prev_collect'] + $totals['safai']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Water Tax -->
                <tr>
                    <td>पाणीपट्टी कर</td>
                    <td><?= $totals['water']['prev_demand'] ?></td>
                    <td><?= $totals['water']['curr_demand'] ?></td>
                    <td><?= $totals['water']['prev_demand'] + $totals['water']['curr_demand'] ?></td>
                    <td><?= $totals['water']['prev_collect'] ?></td>
                    <td><?= $totals['water']['curr_collect'] ?></td>
                    <td><?= $totals['water']['prev_collect'] + $totals['water']['curr_collect'] ?></td>
                    <td><?= $totals['water']['prev_demand'] - $totals['water']['prev_collect'] ?></td>
                    <td><?= $totals['water']['curr_demand'] - $totals['water']['curr_collect'] ?></td>
                    <td><?= ($totals['water']['prev_demand'] + $totals['water']['curr_demand']) - ($totals['water']['prev_collect'] + $totals['water']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Padsar Land -->
                <tr>
                    <td>पडसर जमीन</td>
                    <td><?= $totals['padsar']['prev_demand'] ?></td>
                    <td><?= $totals['padsar']['curr_demand'] ?></td>
                    <td><?= $totals['padsar']['prev_demand'] + $totals['padsar']['curr_demand'] ?></td>
                    <td><?= $totals['padsar']['prev_collect'] ?></td>
                    <td><?= $totals['padsar']['curr_collect'] ?></td>
                    <td><?= $totals['padsar']['prev_collect'] + $totals['padsar']['curr_collect'] ?></td>
                    <td><?= $totals['padsar']['prev_demand'] - $totals['padsar']['prev_collect'] ?></td>
                    <td><?= $totals['padsar']['curr_demand'] - $totals['padsar']['curr_collect'] ?></td>
                    <td><?= ($totals['padsar']['prev_demand'] + $totals['padsar']['curr_demand']) - ($totals['padsar']['prev_collect'] + $totals['padsar']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Fine -->
                <tr>
                    <td>दंड</td>
                    <td><?= $totals['fine']['prev_demand'] ?></td>
                    <td><?= $totals['fine']['curr_demand'] ?></td>
                    <td><?= $totals['fine']['prev_demand'] + $totals['fine']['curr_demand'] ?></td>
                    <td><?= $totals['fine']['prev_collect'] ?></td>
                    <td><?= $totals['fine']['curr_collect'] ?></td>
                    <td><?= $totals['fine']['prev_collect'] + $totals['fine']['curr_collect'] ?></td>
                    <td><?= $totals['fine']['prev_demand'] - $totals['fine']['prev_collect'] ?></td>
                    <td><?= $totals['fine']['curr_demand'] - $totals['fine']['curr_collect'] ?></td>
                    <td><?= ($totals['fine']['prev_demand'] + $totals['fine']['curr_demand']) - ($totals['fine']['prev_collect'] + $totals['fine']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Notice Fee -->
                <tr>
                    <td>नोटीस फी</td>
                    <td><?= $totals['notice']['prev_demand'] ?></td>
                    <td><?= $totals['notice']['curr_demand'] ?></td>
                    <td><?= $totals['notice']['prev_demand'] + $totals['notice']['curr_demand'] ?></td>
                    <td><?= $totals['notice']['prev_collect'] ?></td>
                    <td><?= $totals['notice']['curr_collect'] ?></td>
                    <td><?= $totals['notice']['prev_collect'] + $totals['notice']['curr_collect'] ?></td>
                    <td><?= $totals['notice']['prev_demand'] - $totals['notice']['prev_collect'] ?></td>
                    <td><?= $totals['notice']['curr_demand'] - $totals['notice']['curr_collect'] ?></td>
                    <td><?= ($totals['notice']['prev_demand'] + $totals['notice']['curr_demand']) - ($totals['notice']['prev_collect'] + $totals['notice']['curr_collect']) ?>
                    </td>
                </tr>

                <!-- Discount -->
                <tr>
                    <td>सूट</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td><?= $totals['discount']['prev_collect'] ?></td>
                    <td><?= $totals['discount']['curr_collect'] ?></td>
                    <td><?= $totals['discount']['prev_collect'] + $totals['discount']['curr_collect'] ?></td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>

                <!-- Grand Total -->
                <tr>
                    <th>एकूण रुपये</th>
                    <th><?= $grand_totals['prev_demand'] ?></th>
                    <th><?= $grand_totals['curr_demand'] ?></th>
                    <th><?= $grand_totals['prev_demand'] + $grand_totals['curr_demand'] ?></th>
                    <th><?= $grand_totals['prev_collect'] ?></th>
                    <th><?= $grand_totals['curr_collect'] ?></th>
                    <th><?= $grand_totals['prev_collect'] + $grand_totals['curr_collect'] ?></th>
                    <th><?= $grand_totals['prev_balance'] ?></th>
                    <th><?= $grand_totals['curr_balance'] ?></th>
                    <th><?= $grand_totals['prev_balance'] + $grand_totals['curr_balance'] ?></th>
                </tr>

                <!-- Property Counts -->
                <tr>
                    <th rowspan="2">एकूण मिळकती संख्या</th>
                    <th>एकूण मागील मागणी मिळकती संख्या</th>
                    <th>एकूण चालू मागणी मिळकती संख्या</th>
                    <th>एकूण मागणी मिळकती संख्या</th>
                    <th>एकूण मागील वसूल मिळकती संख्या</th>
                    <th>एकूण चालू वसूल मिळकती संख्या</th>
                    <th>एकूण वसूल मिळकती संख्या</th>
                    <th>एकूण मागील बाकी मिळकती संख्या</th>
                    <th>एकूण चालू बाकी मिळकती संख्या</th>
                    <th>एकूण बाकी मिळकती संख्या</th>
                </tr>
                <tr>
                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['previous_mangani_total_tax'] ?? 0) > 0;
                    })) ?></td>
                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['current_mangani_total_tax'] ?? 0) > 0;
                    })) ?></td>
                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['previous_mangani_total_tax'] ?? 0) > 0 || ($row['current_mangani_total_tax'] ?? 0) > 0;
                    })) ?></td>

                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['previous_vasul_total_tax'] ?? 0) > 0;
                    })) ?></td>
                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['current_vasul_total_tax'] ?? 0) > 0;
                    })) ?></td>
                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['previous_vasul_total_tax'] ?? 0) > 0 || ($row['current_vasul_total_tax'] ?? 0) > 0;
                    })) ?></td>
                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['previous_mangani_total_tax'] ?? 0) - ($row['previous_vasul_total_tax'] ?? 0) > 0;
                    })) ?></td>
                    <td><?= count(array_filter($result, function ($row) {
                        return ($row['current_mangani_total_tax'] ?? 0) - ($row['current_vasul_total_tax'] ?? 0) > 0;
                    })) ?></td>
                    <td><?= count(array_filter($result, function ($row) {
                        return (($row['previous_mangani_total_tax'] ?? 0) + ($row['current_mangani_total_tax'] ?? 0)) -
                            (($row['previous_vasul_total_tax'] ?? 0) + ($row['current_vasul_total_tax'] ?? 0)) > 0;
                    })) ?></td>
                </tr>

                <!-- Uncollected Properties -->
                <tr>
                    <th colspan="5">वसूल न झालेल्या मिळकतीची संख्या: </th>
                    <th colspan="5">वसूल न झालेल्या मिळकतीची रक्कम: </th>
                </tr>
                <tr>
                    <td colspan="5"><?= count(array_filter($result, function ($row) {
                        return (($row['previous_vasul_total_tax'] ?? 0) + ($row['current_vasul_total_tax'] ?? 0)) == 0;
                    })) ?></td>
                    <td colspan="5"><?= array_reduce($result, function ($carry, $row) {
                        if ((($row['previous_vasul_total_tax'] ?? 0) + ($row['current_vasul_total_tax'] ?? 0)) == 0) {
                            return $carry + (($row['previous_mangani_total_tax'] ?? 0) + ($row['current_mangani_total_tax'] ?? 0));
                        }
                        return $carry;
                    }, 0) ?></td>
                </tr>

                <!-- Declaration Date -->
                <tr>
                    <th colspan="10">घोषवारा अद्यावत दिनांक पर्यंत: <?= date('d-m-Y') ?></th>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">कोणतेही डेटा सापडले नाही</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="flex ">
        <div>
            <p>टीप.-
            </p>
        </div>
        <div>
            <p>(१) सूट मंजूर करणाऱ्या आदेशाची शेऱ्यांसह नोंद करण्यात यावी.
            </p>
            <p>(२) सरपंचाने शेरे व दुरुस्त्या अनुप्रमाणित कराव्यात.
            </p>
        </div>
    </div>

</body>

</html>