<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

$data = json_decode(file_get_contents("php://input"), true);

$village = $data['village'] ?? '';
$period = $data['period'] ?? '';
$malmattaId = $data['malmattaId'] ?? '';

$response = ['success' => false];

if ($village && $period && $malmattaId) {
    // Get full malmatta entry with properties + water tax
    $malmattaData = $fun->getMalmattaWithPropertiesWithId($malmattaId, $_SESSION['district_code']);
    // print_r($malmattaData);
    if ($malmattaData) {
        $response['success'] = true;
        $response['info'] = $malmattaData;

        // ✅ Extract total area from properties
        $totalArea = 0;
        $malmattaEntry = $malmattaData[0] ?? null;

if ($malmattaEntry && isset($malmattaEntry['properties'])) {
    foreach ($malmattaEntry['properties'] as $prop) {
        $totalArea += (int) ($prop['area'] ?? 0);
    }
}


        // ✅ Fetch applicable tax rate
        $db = $connect->dbConnect();
        $taxQuery = "SELECT * FROM tax_info WHERE lgdcode = '{$_SESSION['district_code']}'";
        $taxResult = $db->query($taxQuery);

        $reedirecQuery = "SELECT * FROM readyrec_info WHERE revenue_village = '$village'";
        $reedirecResult = $db->query($reedirecQuery);
        if ($reedirecResult && $reedirecResult->num_rows > 0) {
            $row = $reedirecResult->fetch_assoc();
            $response['readyrec'] = $row;
        }

        if ($taxResult && $taxResult->num_rows > 0) {
            while ($row = $taxResult->fetch_assoc()) {
                if (preg_match('/(\d+)\s*to\s*(\d+)/u', $row['area_range'], $matches)) {
                    $min = (int) $matches[1];
                    $max = (int) $matches[2];
                    if ($totalArea >= $min && $totalArea <= $max) {
                        $response['tax_rates'] = $row;
                        break;
                    }
                }
            }
        }

        // ✅ Water tariff (assuming one type for now)
        $response["water_tariff"] = $fun->getWaterTariffByDrainageType("सामान्य पाणीपट्टी", $_SESSION['district_code']);
    }
}

header('Content-Type: application/json');
echo json_encode($response);