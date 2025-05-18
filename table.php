<?php 
    require_once './include/auth_middleware.php';
?>



<?php include('include/header.php'); ?>


<?php
    if(!isset($_GET['type'])) {
        header('Location: namuna8_ahaval_assesment_register.php');
        exit();
    }else{
        $type = $_GET['type'];
        $period = $_GET['period'];
        $ward = $_GET['ward'];
        $road  = $_GET['road'];
        $year  = $_GET['year'];
        $period_deatil = $fun->getPeriodDetailsWithId($_SESSION['district_code'],$period);
        $ward_details = $fun->getWardById($ward);
        if(mysqli_num_rows($ward_details) > 0){
            $ward_details = mysqli_fetch_assoc($ward_details);
        }else{
            $ward_details = [];
        }
        $road_details = $fun->getRoadById($road);
        if(mysqli_num_rows($road_details) > 0){
            $road_details = mysqli_fetch_assoc($road_details);
        }
        if($type == 'संपूर्ण अहवाल'){

            $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriod($period);
        }else if($type == 'वॉर्ड नुसार अहवाल'){
            $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndWard($period, $ward);
        }else if ($type == 'रस्त्यानुसार अहवाल'){
            $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriodAndRoad($period, $road);
        }else {
            $malmatta = $fun->getMalmattaWithPropertiesAccordingToPeriod($period);
        }
        $data = [];
        $i = 1;
        $total_period = $period_deatil['total_period'];
        $ward_name = $ward_details['ward_name'] ?? '';
        $html = "";
           $html .= '<div id="namuna8">
            <h1>नमुना ८ - नियम ३२(१)</h1>
            <h2>सन '.($year??$total_period).' साठी कर आकारणी नोंदवही</h2>
            <h3>ग्रामपंचायत: '.$_SESSION['village_name'].' , वॉर्ड क्र: '.$ward_name.', राज्य: '.$_SESSION['state'].', जिल्हा: '.$_SESSION['district_name'].'</h3>
            <table border="1" cellpadding="2" cellspacing="0">
                <thead>
                    <tr>
                        <th width="30" rowspan="3">क्र</th>
                        <th width="80" rowspan="3">रस्त्याचे नाव</th>
                        <th width="100" rowspan="3">गट क्र. भूमापन क्र</th>
                        <th width="90" rowspan="3">माल मत्ता क्रमांक</th>
                        <th width="60" rowspan="3">मालकाचे नाव (धारण करणाऱ्याचे नाव)</th>
                        <th width="60" rowspan="3">भोगवटा करणान्याचे
                            नाव</th>
                        <th width="50" rowspan="3">मालमत्तेचे वर्णन</th>
                        <th width="50" rowspan="3">भारांक</th>
                        <th width="70" rowspan="3">क्षेत्रफळ ची मी/(चौ.फू)</th>
                        <th width="50" rowspan="1" colspan="3">रेडीरेकनर दर प्रति
                            चो मी</th>
                        <th width="60" rowspan="3">घसारा दर</th>
                        <th width="60" rowspan="3">इ. वापरा नुसार भारांक</th>
                        <th width="60" rowspan="3">भांडवली मूल्य</th>
                        <th width="60" rowspan="3">करा चा दर</th>
                        <th width="60" rowspan="1" colspan="5">कराची रक्कम (रूपये)</th>
                        <th width="60" rowspan="1" colspan="5">अपिलाचे निकाल आणी त्यानंतर केलेले फेरफार (रूपये)</th>
                        <th width="60" rowspan="3">नंतर वाढकिंवा घट झालेल्या याबाबतीत आदेशाच्या संदर्भात शेरा</th>
                    </tr>
                    <tr>
                        <th width="60" rowspan="2">जमिन</th>
                        <th width="60" rowspan="2">इमारत</th>
                        <th width="60" rowspan="2">बांधकाम</th>
                        <th width="60" rowspan="2">इमारत कर</th>
                        <th width="60" rowspan="2">दिवाबत्ती</th>
                        <th width="60" rowspan="2">आरोग्य</th>
                        <th width="60" rowspan="2">पाणी पटटी</th>
                        <th width="60" rowspan="2">एकूण</th>
                        <th width="60" rowspan="2">इमारत कर</th>
                        <th width="60" rowspan="2">दिवाबत्ती</th>
                        <th width="60" rowspan="2">आरोग्य</th>
                        <th width="60" rowspan="2">पाणी पटटी</th>
                        <th width="60" rowspan="2">एकूण</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($malmatta as $row) {
            // print_r($row);
            foreach ($row['properties'] as $property) {
                 
    
            // ✅ Water tariff (assuming one type for now)
            $total_tax = $row['light_tax'] + $row['health_tax'] + $row['water_tax'] + $property['building_value'];
            $response["water_tariff"] = $fun->getWaterTariffByDrainageType("सामान्य पाणीपट्टी", $_SESSION['district_code']);
                $data[] = [
                    $i,
                    $row['road_name'],
                    $row['group_no'] . '/' . $row['city_survey_no'],
                    $row['malmatta_no'],
                    $row['owner_name'] . ' (' . $row['occupant_name'] . ')',
                    $row['occupant_name'],
                    $property['property_use'],
                    $property['bharank'],
                    $property['areaInMt'] . ' / ' . $property['areaInFoot'],
                     $property['areaInFoot'],
                    '', // जमिन (land) - you can map it if available
                    $property['construction_tax'], // बांधकाम (construction) - you can map it if needed
                    $property['ghasara_tax'],
                    $property['bharank'], // Reused for इ. वापरा नुसार भारांक
                    $property['bhandavali'],
                    $property['milkat_fixed_tax'],
                    $property['building_value'], $row['light_tax'], $row['health_tax'], $row['water_tax'], $total_tax, // कराची रक्कम (tax amounts) placeholders
                    '', '', '', '', '', // अपिलाचे निकाल... placeholders
                    $row['remarks'],
                ];
                $i++;
            }
        }
    
    
        
     
             
        foreach ($data as $row) {
            $html .= "<tr>";
            foreach ($row as $cell) {
                $html .= "<td width='14.81mm'>".htmlspecialchars($cell, ENT_QUOTES, 'UTF-8')."</td>";
            }
            $html .= '</tr>';
        }
        
        
        $html .="</tbody>
        </table>
        </div>";
        echo $html;        
    }
    ?>