<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";
if (!isset($title)) {
    $title = "";
}

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

if (!isset($_GET['type'])) {
    header('Location: namuna8_ahaval_assesment_register.php');
    exit();
}

$type = $_GET['type'] ?? '';
$period = $_GET['period'] ?? '';
$ward = $_GET['ward'] ?? '';
$road = $_GET['road'] ?? '';
$year = $_GET['year'] ?? '';
$malmatta_no = $_GET['malmatta_no'] ?? '';
$khasara_no = $_GET['khasara_no'] ?? '';
$village = $_GET['village'] ?? '';
$drainage_type = $_GET['drainage_type'] ?? '';
$milkat_type = $_GET['income_type'] ?? '';
$washroom_available = $_GET['washroom_available'] ?? '';

// print_r($_GET);

// Get details
$period_detail = $fun->getPeriodDetailsWithId($_SESSION['district_code'], $period);
$ward_details = $fun->getWardById($ward);
$ward_details = mysqli_num_rows($ward_details) > 0 ? mysqli_fetch_assoc($ward_details) : [];
$road_details = $fun->getRoadById($road);
$road_details = mysqli_num_rows($road_details) > 0 ? mysqli_fetch_assoc($road_details) : [];

// Get data based on type
if ($type == 'संपूर्ण अहवाल') {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriod($period);
} elseif ($type == 'वॉर्ड नुसार अहवाल') {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndWard($period, $ward);
} elseif ($type == 'रस्त्यानुसार अहवाल') {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndRoad($period, $road);
} else if ($type == "milkat_no") {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndMalmatta_no($period, $malmatta_no);
} elseif ($type == "paniwapar") {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndDrainageType($period, $drainage_type);
} elseif ($type == "washroom_available") {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndWashroomAvailable($period, $washroom_available);
} else if ($type == "milkat_type") {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndMilakatType($period, $milkat_type);
} else if ($type == "खसारानुसर अहवाल") {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndKhasara($period, $khasara_no);
} else if ($type == "गावनुसार अहवाल") {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndVillage($period, $village);
} else {
    $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriod($period);
}
$locationData = $fun->getLgdTableWithVillageCode($_SESSION['village_code']);
$locationData = mysqli_fetch_assoc($locationData);
// print_r($locationData);
$total_period = $period_detail['total_period'] ?? '';
$ward_name = $ward_details['ward_name'] ?? '';
// print_r($malmatta);
// echo "<br>";
// echo "<br>";
// echo "<br> type";
// echo $type."<br> period ";
// echo $period."<br> ward";
// echo $ward."<br> road";
// echo $road."<br> year";
// echo $year."<br> malmatta_no";
// echo $malmatta_no."<br> drainage_type";
// echo $drainage_type."<br> washroom_available";
// echo $washroom_available."<br> milkat_type ";
// echo $milkat_type."<br>";
// echo "<br>";
// print_r($malmatta);
// exit();
$total_building_value = 0;
$total_light_tax = 0;
$total_health_tax = 0;
$total_water_tax = 0;
$total_padsar_tax = 0;
$total_tax_amount = 0;
?>

<!DOCTYPE html>
<html lang="mr">

<head>
    <meta charset="UTF-8">
    <title>थकबाकी यादी</title>
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
            border: 1px solid #000;
            padding: 4px;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
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
    </style>
</head>

<body>
    <div class="text-center">
        <h2 class="text-center">नमुना ८ नियम ३२(१)</h2>
        <p>सन. २०२३-२०२७ साठी कर आकारणी नोंदवही</p>
        <div class="flex justify-between">
            <p>ग्रामपंचायत: <?php echo htmlspecialchars($locationData["Village_Panchayat_Name_TLB_Name"]); ?>
            </p>
            <p>तालुकाः <?php echo htmlspecialchars($locationData['Development_Block_Name']); ?> </p>
            <p>जिल्हा: <?php echo htmlspecialchars($locationData['District_Name']); ?> </p>
            <?php if ($ward_name): ?>
                <p>वॉर्ड क्रमांक: <?php echo htmlspecialchars($ward_name); ?></p>

            <?php endif; ?>
        </div>
    </div>
    <table>

        <thead>
            <tr>
                <th rowspan="4">अ.क्र.</th>
                <th rowspan="4">रस्त्याचे नाव/गल्लीचे नाव</th>
                <th rowspan="4" class="vertical-text">गट क्र. भूमापन क्र.</th>
                <th rowspan="4">मालमत्ता क्र.</th>
                <th rowspan="4" colspan="3">मालमत्ता धारकाचे नाव<br>(धारण करणाऱ्याचे नाव)</th>
                <th rowspan="4" colspan="2">भोगवटा करणाऱ्याचे नाव</th>
                <th rowspan="4" colspan="2">मालमत्तेचे वर्णन</th>
                <th rowspan="4" colspan="2" class="vertical-text">मिळकत बांधकामाचे वर्ष<br>(मिळकतीचे वायोमान
                    वर्षांमध्ये)</th>
                <th colspan="2" rowspan="4">क्षेत्रफळ चौ. मी. (चौ. फू)</th>
                <th colspan="3" rowspan="2">रेडीरेकनर दर प्रति चौ. मी.</th>
                <th rowspan="4" class="vertical-text">घसारा दर</th>
                <th rowspan="4" class="vertical-text">इ. वापरानुसार भारांक</th>
                <th rowspan="4" class="vertical-text">भांडवली मूल्य</th>
                <th rowspan="4" class="vertical-text">कराचा दर</th>
                <th colspan="5" rowspan="2">वार्षिक कराची रक्कम (रुपयात)</th>
                <th colspan="5" rowspan="2">आपिलाचे निकाल व त्यावर केलेले फेरफार</th>
                <th colspan="3" rowspan="4">नंतर वाढ किंवा घट झालेल्या बाबतीत आदेशाच्या संदर्भात शेरा</th>
            </tr>
            <tr></tr>
            <tr>
                <th rowspan="2" class="vertical-text">जमीन</th>
                <th rowspan="2" class="vertical-text">इमारत</th>
                <th rowspan="2" class="vertical-text">बांधकाम</th>

                <th rowspan="2" class="vertical-text">इमारत कर</th>
                <th rowspan="2" class="vertical-text">दिवाबत्ती कर</th>
                <th rowspan="2" class="vertical-text">आरोग्य कर</th>
                <th rowspan="2" class="vertical-text">सार्व,/खास पा. पट्टी</th>
                <th rowspan="2" class="vertical-text">एकूण</th>

                <th rowspan="2" class="vertical-text">इमारत कर</th>
                <th rowspan="2" class="vertical-text">दिवाबत्ती कर</th>
                <th rowspan="2" class="vertical-text">आरोग्य कर</th>
                <th rowspan="2" class="vertical-text">सार्व,/खास पा. पट्टी</th>
                <th rowspan="2" class="vertical-text">एकूण</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>१</td>
                <td>२</td>
                <td>३</td>
                <td>४</td>
                <td colspan="3">५</td>
                <td colspan="2">६</td>
                <td colspan="2">७</td>
                <td colspan="2">८</td>
                <td colspan="2">९</td>
                <td>१0</td>
                <td>११</td>
                <td>१२</td>
                <td>१३</td>
                <td>१४</td>
                <td>१५</td>
                <td>१६</td>
                <td>१७</td>
                <td>१८</td>
                <td>१९</td>
                <td>२०</td>
                <td>२१</td>
                <td>२२</td>
                <td>२३</td>
                <td>२४</td>
                <td>२५</td>
                <td>२६</td>
                <td colspan="3">२७</td>
            </tr>
            <?php
            $i = 1;
            foreach ($malmatta as $row):
                foreach ($row['properties'] as $property):
                    $total_tax = $row['light_tax'] + $row['health_tax'] + $row['water_tax'] + $property['building_value'];
                    $total_building_value += $property['building_value'] ?? 0;
                    $total_light_tax += $row['light_tax'] ?? 0;
                    $total_health_tax += $row['health_tax'] ?? 0;
                    $total_water_tax += $row['water_tax'] ?? 0;
                    $total_padsar_tax += $property['ghasara_tax'] ?? 0;
                    $total_tax_amount += $total_tax;

                    ?>
                    <tr class="data-row">
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['road_name']) ?></td>
                        <td><?= htmlspecialchars($row['group_no'] . '/' . $row['city_survey_no']) ?></td>
                        <td><?= htmlspecialchars($row['malmatta_no']) ?></td>
                        <td colspan="3"><?= htmlspecialchars($row['owner_name'] . ' (' . $row['occupant_name'] . ')') ?></td>
                        <td colspan="2"><?= htmlspecialchars($row['occupant_name']) ?></td>
                        <td colspan="2"><?= htmlspecialchars($property['property_use']) ?></td>
                        <td colspan="2"><?= htmlspecialchars($property['construction_year'] ?? '') ?></td>
                        <td colspan="2"><?= htmlspecialchars($property['areaInMt'] . ' / ' . $property['areaInFoot']) ?></td>
                        <td><?= htmlspecialchars($property['yearly_tax'] ?? '') ?></td>
                        <td><?= htmlspecialchars($property['building_rate'] ?? '') ?></td>
                        <td><?= htmlspecialchars($property['construction_tax']) ?></td>
                        <td class=""><?= htmlspecialchars($property['ghasara_tax']) ?></td>
                        <td class=""><?= htmlspecialchars($property['bharank']) ?></td>
                        <td class="vertical-text"><?= htmlspecialchars($property['bhandavali']) ?></td>
                        <td><?= htmlspecialchars($property['milkat_fixed_tax']) ?></td>
                        <td><?= htmlspecialchars($property['building_value']) ?></td>
                        <td><?= htmlspecialchars($row['light_tax']) ?></td>
                        <td><?= htmlspecialchars($row['health_tax']) ?></td>
                        <td><?= htmlspecialchars($row['water_tax']) ?></td>
                        <td><?= htmlspecialchars($total_tax) ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="3"><?= htmlspecialchars($row['remarks']) ?></td>
                    </tr>
                <?php endforeach; endforeach; ?>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th>एकूण इमारत कर</th>
                <th>एकूण दिवाबत्ती कर</th>
                <th>एकूण आरोग्य कर</th>
                <th>एकूण पाणीपटी</th>
                <th>एकूण पडसर कर</th>
                <th>एकूण कराची रक्कम</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($total_building_value) ?></td>
                <td><?= htmlspecialchars($total_light_tax) ?></td>
                <td><?= htmlspecialchars($total_health_tax) ?></td>
                <td><?= htmlspecialchars($total_water_tax) ?></td>
                <td><?= htmlspecialchars($total_padsar_tax) ?></td>
                <td><?= htmlspecialchars($total_tax_amount) ?></td>
            </tr>
        </tbody>
    </table>

    <div class="flex">
        <div>
            <p style="font-size: 10px;">1- सदरचा उतारा हा मालकी हक्कचा नसून कर आकारणीचा आहे, सदरच्या उताऱ्यावरून खरेदी
                विक्रीचा व्यवहार झालेस
                त्यास ग्रामपंचायत जबाबदार राहणार नाही.</p>
            <p style="font-size: 10px;">2-शासन परिपत्रक क्र. VTM२६०३/प्र.क्र. २०६८/पं.रा. ४ दि २० नोव्हेंबर २००३ नुसार
                ग्रामीण भागातील घरांची
                नोंदणी पती-पत्नी यांच्या संयुक्त नावे करण्याबाबत निर्देशित करण्यात आलेले आहे.</p>
        </div>
        <div>
            <p>येणे प्रमाणे उतारा दिला असे दिनांक :</p>
        </div>
    </div>

</body>

</html>