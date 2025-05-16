<?php

class Fun
{
    private $db;
    public $milkatObject ;
    public $ghasaraDarGroupA= [
        100, 95,85,75,60,45,30,20,15
    ];
    public $ghasaraDarGroupB = [
        100, 95,90,80,70,60,50,40,30
    ];
    public $propertyUseGroupA = [
        "अर्ध पक्के घर (दगड विटांचे मातीचे घर)", "कच्चे घर (झोपडी किंवा मातीचे घर)"
    ];
    public $propertyUseGroupB = [
        "आर सी सी पद्धतीचे बांधकाम", "इतर पक्के घर (दगड विटांचे चुना किंवा सिमेंटचे घर)"
    ];
    function __construct($con)
    {
        $this->db = $con;

        $this->milkatObject =  [
    "आर सी सी पद्धतीचे बांधकाम" => "rcc",
    "इतर पक्के घर (दगड विटांचे चुना किंवा सिमेंटचे घर)" =>"itar_pakke_ghar",
    "अर्ध पक्के घर (दगड विटांचे मातीचे घर)"=> "ardha_pakke_ghar",
    "कच्चे घर (झोपडी किंवा मातीचे घर)" => "kache_ghar",
    "पडसर/खुली जागा" => "padsar",
    "मनोरा तळ घर"=> "manora_type_ghar",
    "मनोरा खुली जागा सर्वसाधारण किंवा डोंगराळ आदिवसी क्षेत्र असलेल्या ग्रामपंचायती"=>"manora_khuli_jaga_sarvasadharan",
    "मनोरा खुली जागा महानगरपालिका किंवा नगरपालिका यांच्या लगतच्या ग्रामपंचायती"=> "manora_khuli_jaga_mnc"   
        ];

    }

    public function login($username,$password){
        
        $query    = "SELECT * FROM `user` WHERE `userid`='$username' AND `pass` = '$password'";
        $result = mysqli_query($this->db, $query);

        
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
           $fetch = mysqli_fetch_assoc($result);
                $role = $fetch["role"];
                return $role;
            
           
            // Redirect to user dashboard page
           
             
        }
        else{
            return null;
        }
    }
    //Ward Master
    public function getWard($lgd_code){
        $query = "SELECT * FROM `ward_details` where `lgd_code` = '$lgd_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getWardById($id){
        $query = "SELECT * FROM `ward_details` WHERE `ward_no` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addWard($ward_no,$ward_name,$lgd_code){
        $query = "INSERT INTO `ward_details`(`ward_no`, `ward_name`,`lgd_code`) VALUES ('$ward_no','$ward_name','$lgd_code')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getWardNo(){
        $query = "SELECT MAX(`ward_no`) as `ward_no` FROM `ward_details`";
        $result = mysqli_query($this->db, $query);
        $ward = mysqli_fetch_assoc($result);
        return $ward['ward_no']+1;
    }

    public function updateWard($ward_no,$ward_name){
        $query = "UPDATE `ward_details` SET `ward_name`='$ward_name' WHERE `ward_no` = '$ward_no'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function deleteWard($ward_no){
        $query = "DELETE FROM `ward_details` WHERE `ward_no` = '$ward_no'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }


    //Road Master
    public function getRoad($lgd_code){
        $query = "SELECT * FROM `road_details` where `lgd_code` = '$lgd_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getRoadById($id){
        $query = "SELECT * FROM `road_details` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addRoad($road_name, $lgd_code){
        $query = "INSERT INTO `road_details`( `road_name`,`lgd_code`) VALUES ('$road_name','$lgd_code')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }


    public function updateRoad($id,$road_name){
        $query = "UPDATE `road_details` SET `road_name`='$road_name' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function deleteRoad($road_no){
        $query = "DELETE FROM `road_details` WHERE `road_no` = '$road_no'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    //Duration reason
    public function getDurationReason(){
        $query = "SELECT * FROM `duration_reason`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getDurationReasonById($id){
        $query = "SELECT * FROM `duration_reason` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null; // or handle the case when no rows are found
        }
    }

    //Period Details
    public function getPeriodDetails($lgd_code){
        $query = "SELECT * FROM `period_details` where `lgd_code` = '$lgd_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getPeriodDetailsLastValue($lgd_code){
        $query = "SELECT `total_period`, `id` FROM `period_details` Where `lgd_code` = '$lgd_code' ORDER BY `id` DESC LIMIT 1";
        $result = mysqli_query($this->db, $query);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null; // or handle the case when no rows are found
        }
    }

    public function getPeriodDetailsLastValueByPeriodReason($periodReason, $lgd_code){
        $query = "SELECT * FROM `period_details` WHERE `period_reason` = '$periodReason' and `lgd_code` = '$lgd_code' ORDER BY `id` DESC LIMIT 1";
        $result = mysqli_query($this->db, $query);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null; // or handle the case when no rows are found
        }
    }
    public function getPeriodDetailsAllValueByPeriodReason($periodReason, $lgd_code){
        $query = "SELECT * FROM `period_details` WHERE `period_reason` = '$periodReason' and `lgd_code` = '$lgd_code' ORDER BY `id`";
        $result = mysqli_query($this->db, $query);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null; // or handle the case when no rows are found
        }
    }

    public function getPeriodTotalPeriods($lgd_code){
        $query = "SELECT  `total_period`, `id` FROM `period_details` where `lgd_code` = '$lgd_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getPeriodTotalPeriodsWithPeriodReason($periodReason, $lgd_code){
        $query = "SELECT  `total_period`, `id` FROM `period_details` WHERE `period_reason` = '$periodReason' and `lgd_code` = '$lgd_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getYearArray($periods){
        if(mysqli_num_rows($periods) > 0){
            $row = mysqli_fetch_assoc($periods);
            $total_period = $row['total_period'];
          
           [$start, $end] = explode('-', $total_period);
    $start = (int) $start;
    $end = (int) $end;

    $ranges = [];

    for ($year = $start; $year < $end; $year++) {
        $ranges[] = "$year-" . ($year + 1);
    }

    return $ranges;
        } else {
            return null; // or handle the case when no rows are found
        }
    }

    public function addPeriodDetails($reason, $durationStart, $durationEnd, $duration, $lgd_code) {
        $stmt = $this->db->prepare("INSERT INTO period_details (period_reason, period_start, period_end, total_period, lgd_code) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $reason, $durationStart, $durationEnd, $duration,$lgd_code);
        return $stmt->execute();
    }
    
    public function updatePeriodDetails($id, $reason, $durationStart, $durationEnd, $duration) {
        $stmt = $this->db->prepare("UPDATE period_details SET period_reason = ?, period_start = ?, period_end = ?, total_period = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $reason, $durationStart, $durationEnd, $duration, $id);
        return $stmt->execute();
    }
    

    //drainage types

    public function getDrainageTypes(){
        $query = "SELECT * FROM `drainage_types`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addDrainageTypes($drainageType){
        $query = "INSERT INTO `drainage_types`(`drainage_type`) VALUES ('$drainageType')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getDrainageTypesById($id){
        $query = "SELECT * FROM `drainage_types` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateDrainageTypes($id,$drainageType){
        $query = "UPDATE `drainage_types` SET `drainage_type`='$drainageType' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    //water tariff

    public function getWaterTariff($lgd_code){
        $query = "SELECT *,wt.id as wt_id,  pt.id as pt_id  FROM `water_tariff` wt
            LEFT JOIN `period_details` pt ON wt.`period` = pt.`id` 
            Where wt.`lgd_code` = '$lgd_code'
            ORDER BY wt.id ASC";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addWaterTariff($drainage_type, $period, $min_rate, $fixed_rate, $pipe_diameter, $decison_date, $resolution_no,$max_rate, $lgd_code){
        $query = "INSERT INTO `water_tariff`(`drainage_type`, `period`, `min_rate`,`max_rate` ,`fixed_rate`, `pipe_diameter`, `decision_date`, `resolution_no`, `lgd_code`) VALUES ('$drainage_type', '$period', '$min_rate','$max_rate' ,'$fixed_rate', '$pipe_diameter', '$decison_date', '$resolution_no', '$lgd_code')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getWaterTariffById($id, $lgd_code){
        $query = "SELECT *,wt.id as wt_id,  pt.id as pt_id  FROM `water_tariff` wt
            LEFT JOIN `period_details` pt ON wt.`period` = pt.`id`
         WHERE `id` = '$id' and wt.`lgd_code` = '$lgd_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getWaterTariffByResolutionNo($id, $lgd_code){
        $query = "SELECT *,wt.id as wt_id,  pt.id as pt_id  FROM `water_tariff` wt
            LEFT JOIN `period_details` pt ON wt.`period` = pt.`id` WHERE wt.`resolution_no` = '$id' and wt.`lgd_code` = '$lgd_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getWaterTariffByDrainageType($drainage_type, $lgd_code){
        $query = "SELECT * FROM `water_tariff` WHERE `drainage_type` = '$drainage_type' and lgd_code = '$lgd_code' ORDER BY id ASC LIMIT 1";
        $result = mysqli_query($this->db, $query);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return null; // or handle the case when no rows are found
        }
    }

    public function updateWaterTariff($id,$drainage_type, $period, $min_rate, $fixed_rate, $pipe_diameter, $decison_date, $resolution_no, $max_tax){
        echo $id." ".$drainage_type." ".$period." ".$min_rate." ".$fixed_rate." ".$pipe_diameter." ".$decison_date." ".$resolution_no;
        $query = "UPDATE `water_tariff` SET `drainage_type`='$drainage_type', `period`='$period', `min_rate`='$min_rate', `fixed_rate`='$fixed_rate', `pipe_diameter`='$pipe_diameter', `decision_date`='$decison_date', `resolution_no`='$resolution_no', `max_rate` = '$max_tax' WHERE `id` = '$id'";
         echo $query;
        $result = mysqli_query($this->db, $query);
        // print_r($result);
        return $result;
    }


    // financial years

    public function getFinancialYears(){
        $query = "SELECT * FROM `financial_years`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addFinancialYears($financial_year){
        $query = "INSERT INTO `financial_years`(`financial_year`) VALUES ('$financial_year')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getFinancialYearsById($id){
        $query = "SELECT * FROM `financial_years` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateFinancialYears($id,$financial_year){
        $query = "UPDATE `financial_years` SET `financial_year`='$financial_year' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    // Revenue villages

    public function getRevenueVillages(){
        $query = "SELECT * FROM `revenue_villages`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addRevenueVillages($revenue_village){
        $query = "INSERT INTO `revenue_villages`(`village_name`) VALUES ('$revenue_village')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getRevenueVillagesById($id){
        $query = "SELECT * FROM `revenue_villages` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateRevenueVillages($id,$revenue_village){
        $query = "UPDATE `revenue_villages` SET `village_name`='$revenue_village' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    

    // readyrec Parts

    public function getReadyrecParts(){
        $query = "SELECT * FROM `readyrec_parts`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addReadyrecParts($readyrec_part){
        $query = "INSERT INTO `readyrec_parts`(`readyrec_part`) VALUES ('$readyrec_part')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getReadyrecPartsById($id){
        $query = "SELECT * FROM `readyrec_parts` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateReadyrecParts($id,$readyrec_part){
        $query = "UPDATE `readyrec_parts` SET `readyrec_part`='$readyrec_part' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    // readyrec info

    public function getReadyrecInfo(){
        $query = "SELECT *, ri.`id` as rid FROM `readyrec_info` ri
                    Left join lgdtable lt on lt.`Village_Code` =  ri.`revenue_village`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addReadyrecInfo($financial_years, $revenue_village, $readyrec_type, $land_type, $recordings, $yearly_tax){
        $query = "INSERT INTO `readyrec_info`(`financial_years`, `revenue_village`, `readyrec_type`, `land_type`, `recordings`, `yearly_tax`) VALUES ('$financial_years', '$revenue_village', '$readyrec_type', '$land_type', '$recordings', '$yearly_tax')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getReadyrecInfoById($id){
        $query = "SELECT * FROM `readyrec_info` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateReadyrecInfo($id,$financial_years, $revenue_village, $readyrec_type, $land_type, $recordings, $yearly_tax){
        $query = "UPDATE `readyrec_info` SET `financial_years`='$financial_years', `revenue_village`='$revenue_village', `readyrec_type`='$readyrec_type', `land_type`='$land_type', `recordings`='$recordings', `yearly_tax`='$yearly_tax' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

//New name

public function getNewNameById($id){
    $query = "SELECT * FROM `new_name` WHERE `id` = '$id'";
    $result = mysqli_query($this->db, $query);
    return $result;
}

public function addNewName($person_name, $nickname, $gender,$mobile_no,$aadhar_no, $email){
    $query = "INSERT INTO `new_name`(`person_name`, `nickname`, `gender`, `mobile_no`, `aadhar_no`, `email`) VALUES ('$person_name', '$nickname', '$gender', '$mobile_no', '$aadhar_no', '$email')";
    $result = mysqli_query($this->db, $query);
    return $result;
}

public function updateNewName($id,$person_name, $nickname, $gender,$mobile_no,$aadhar_no, $email){
    $query = "UPDATE `new_name` SET `person_name`='$person_name', `nickname`='$nickname', `gender`='$gender', `mobile_no`='$mobile_no', `aadhar_no`='$aadhar_no', `email`='$email' WHERE `id` = '$id'";
    $result = mysqli_query($this->db, $query);
    return $result; 
}

public function getNewName(){
    $query = "SELECT * FROM `new_name`";
    $result = mysqli_query($this->db, $query);
    return $result;

}

public function createMalmatta($data) {
    $sql = "INSERT INTO malmatta (period, village, road, ward, malmatta_no, owner_name, wife_name, occupant_name, mobile_no, city_survey_no, group_no, drainage_type, washroom_availbale, gram)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->db->prepare($sql);
    if ($stmt->execute([
        $data['period'], $data['revenue_village'], $data['road_name'], $data['ward_name'], $data['malmatta_no'], 
        $data['owner_name'], $data['owner_wife_name'], $data['occupant_name'], $data['mobile_no'], 
        $data['city_survey_no'], $data['group_number'], $data['drainage_type'], 
        $data['toilet_available'], 1
    ])) {
        return true;
    }
    return false;
}

// Read all malmatta records
function getAllMalmatta() {
    $query = "SELECT *,mt.id as mt_id,nn.person_name as `owner`, nn1.person_name as `wife`, nn2.person_name as `occupant` FROM malmatta mt
                Left join period_details pd on mt.`period` = pd.`id`
                Left join revenue_villages rv on mt.`village` = rv.`id`
                Left join road_details r on mt.`road` = r.`id`
                left join ward_details w on mt.`ward` = w.`id`
                left join new_name nn on mt.`owner_name` = nn.`id`
                left join new_name nn1 on mt.`wife_name` = nn1.`id`
                left join new_name nn2 on mt.`occupant_name` = nn2.`id`
                ORDER BY mt.id ASC";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    
    $result = $stmt->get_result(); // Get the result set

 
        return $result; // Fetch all rows as associative array
    
}


// Read a single malmatta record by ID
public function getMalmattaById($id) {
    $sql = "SELECT * FROM malmatta WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update a malmatta record
public function updateMalmatta($id, $data) {
    $sql = "UPDATE malmatta SET 
            period = ?, village = ?, road = ?, ward = ?, malmatta_no = ?, 
            owner_name = ?, wife_name = ?, occupant_name = ?, mobile_no = ?, 
            city_survey_no = ?, group_no = ?, drainage_type = ?, 
            washroom_availbale = ?, gram = ?
            WHERE id = ?";

    $stmt = $this->db->prepare($sql);
    if ($stmt->execute([
        $data['period'], $data['revenue_village'], $data['road_name'], $data['ward_name'], $data['malmatta_no'], 
        $data['owner_name'], $data['owner_wife_name'], $data['occupant_name'], $data['mobile_no'], 
        $data['city_survey_no'], $data['group_number'], $data['drainage_type'], 
        $data['toilet_available'], 1, $id
    ])) {
        return true;
    }
    return false;
}

// Delete a malmatta record
public function deleteMalmatta($id) {
    $sql = "DELETE FROM malmatta WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$id]);
}

    // Income type

    public function getIncomeType(){
        $query = "SELECT * FROM `income_type`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addIncomeType($income_type){
        $query = "INSERT INTO `income_type`(`income_type`) VALUES ('$income_type')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    // tax exempt

    public function getTaxExempt(){
        $query = "SELECT * FROM `tax_exempt`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addTaxExempt($tax_exempt){
        $query = "INSERT INTO `tax_exempt`(`tax_exempt`) VALUES ('$tax_exempt')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    // malmatta use

    public function getMalmattaUse(){
        $query = "SELECT * FROM `malmatta_use`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addMalmattaUse($malmatta_use){
        $query = "INSERT INTO `malmatta_use`(`malmatta_use`) VALUES ('$malmatta_use')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }


    //malmatta tax type

    public function getMalmattaTaxType(){
        $query = "SELECT * FROM `malmatta_tax_type`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addMalmattaTaxType($malmatta_tax_type){
        $query = "INSERT INTO `malmatta_tax_type`(`malmatta_tax_type`) VALUES ('$malmatta_tax_type')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    //building floors

    public function getBuildingFloors(){
        $query = "SELECT * FROM `building_floors`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addBuildingFloors($building_floors){
        $query = "INSERT INTO `building_floors`(`floor_name`) VALUES ('$building_floors')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    // Tax Info 

    public function getTaxInfo($lgdcode){
        $query = "SELECT * FROM `tax_info` where `lgdcode` = '$lgdcode'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addTaxInfo($area_range, $arogya_kiman_rate, $arogya_kamal_rate, $arogya_prap_tharabaila_rate, $divabatti_kiman_rate, $divabatti_kamal_rate, $divabatti_prap_tharabaila_rate, $lgdcode){
        $query = "INSERT INTO `tax_info`(`area_range`, `arogya_kiman_rate`, `arogya_kamal_rate`, `arogya_prap_tharabaila_rate`, `divabatti_kiman_rate`, `divabatti_kamal_rate`, `divabatti_prap_tharabaila_rate`) VALUES ('$area_range', '$arogya_kiman_rate', '$arogya_kamal_rate', '$arogya_prap_tharabaila_rate', '$divabatti_kiman_rate', '$divabatti_kamal_rate', '$divabatti_prap_tharabaila_rate', '$lgdcode')";
       
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getTaxInfoById($id,$lgdcode){
        $query = "SELECT * FROM `tax_info` WHERE `id` = '$id' and lgdcode = '$lgdcode'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getTaxInfoByArea($area, $lgdcode){
        switch ($area) {
            case $area >=1 && $area<=300:
                $area_range = '1 ते 300';
                break;
            case $area >=301 && $area<=700:
                $area_range = '301 ते 700';
                break;
            case $area >=701:
                $area_range = '701 ते 9999';
                break;
        }
        $query = "SELECT * FROM `tax_info` WHERE `area_range` = '$area_range' and lgdcode = '$lgdcode'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateTaxInfo($id, $arogya_kiman_rate, $arogya_kamal_rate, $arogya_prap_tharabaila_rate, $divabatti_kiman_rate, $divabatti_kamal_rate, $divabatti_prap_tharabaila_rate, $decision_no) {
        $query = "UPDATE `tax_info` SET  
            `arogya_kiman_rate`='$arogya_kiman_rate', 
            `arogya_kamal_rate`='$arogya_kamal_rate', 
            `arogya_prap_tharabaila_rate`='$arogya_prap_tharabaila_rate', 
            `divabatti_kiman_rate`='$divabatti_kiman_rate', 
            `divabatti_kamal_rate`='$divabatti_kamal_rate', 
            `divabatti_prap_tharabaila_rate`='$divabatti_prap_tharabaila_rate',
            `tharava_no`='$decision_no', 
            `status`='0' 
            WHERE `id` = '$id'";
        
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    
    //tharav
    public function getTharav(){
        $query = "SELECT * FROM `tharav`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addTharav($tharav_date, $tharav_no, $for_period, $lgd_code){
        $query = "INSERT INTO `tharav`(`tharav_date`, `tharav_no`, `for_period`, `lgdcode`) VALUES ('$tharav_date', '$tharav_no', '$for_period','$lgd_code')";
       
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getTharavById($id){
        $query = "SELECT * FROM `tharav` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getTharavByNo($id){
        $query = "SELECT * FROM `tharav` WHERE `tharav_no` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getTharavByPeriod($id){
        $query = "SELECT * FROM `tharav` WHERE `for_period` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function updateTharav($id,$tharav_date, $tharav_no, $for_period){
        $query = "UPDATE `tharav` SET `tharav_date`='$tharav_date', `tharav_no`='$tharav_no', `for_period`='$for_period' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function isTharavExists($for_period) {
        $query = "SELECT * FROM `tharav` WHERE `for_period` = '$for_period'";
        $result = mysqli_query($this->db, $query);
        return mysqli_num_rows($result) > 0;
    }

    // malmatta_data_entry


    public function getMalmattaDataEntry($lgdcode){
        $query = "SELECT *, mde.`id` as `malmatta_id`, mde.`malmatta_no` as 'malmatta_number', nno.`person_name` as `owner_name`, nno1.`person_name` as `wife_name`, nno2.`person_name` as `occupant_name` FROM `malmatta_data_entry` mde
                    Left Join malmatta_property_info mpi on mde.`id` = mpi.`malmatta_id`
                    left join period_details pd on mde.`period` = pd.`id`
                    left join malmatta_water_tax mw on mde.`id` = mw.`malmatta_id`
                    left join road_details rd on mde.`road_name` = rd.`id`
                    left join ward_details wd on mde.`ward_no`= wd.`id`
                    left join new_name nno on mde.`owner_name` = nno.`id`
                    left join new_name nno1 on mde.`wife_name` = nno1.`id`
                    left join new_name nno2 on mde.`occupant_name` = nno2.`id`
                    Where mde.`lgdcode` = '$lgdcode' and mde.`approved` = '0' ;";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getMalmattaDataEntryByPeriod($lgdcode, $period){
        $query = "SELECT *, mde.`id` as `malmatta_id`, mde.`malmatta_no` as 'malmatta_number', nno.`person_name` as `owner_name`, nno1.`person_name` as `wife_name`, nno2.`person_name` as `occupant_name` FROM `malmatta_data_entry` mde
                    Left Join malmatta_property_info mpi on mde.`id` = mpi.`malmatta_id`
                    left join period_details pd on mde.`period` = pd.`id`
                    left join malmatta_water_tax mw on mde.`id` = mw.`malmatta_id`
                    left join road_details rd on mde.`road_name` = rd.`id`
                    left join ward_details wd on mde.`ward_no`= wd.`id`
                    left join new_name nno on mde.`owner_name` = nno.`id`
                    left join new_name nno1 on mde.`wife_name` = nno1.`id`
                    left join new_name nno2 on mde.`occupant_name` = nno2.`id`
                    Where mde.`lgdcode` = '$lgdcode' and mde.`approved` = '0' and mde.`period` = '$period' ;";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getMalmattaDataEntryByLgdcode($lgdcode){
        $query = "SELECT * FROM `malmatta_data_entry` mde
                    Where mde.`lgdcode` = '$lgdcode' ;";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getMalmattaDataEntryByLgdcodeApproved($lgdcode){
        $query = "SELECT * FROM `malmatta_data_entry` mde
                    Where mde.`lgdcode` = '$lgdcode' AND mde.`approved` = '1' AND mde.`verified` = '0' ;";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addMalmattaDataEntry($period, $village_name, $ward_no, $road_name, $malmatta_no, $city_survey_no, $group_no, $washroom_available, $owner_name, $wife_name, $occupant_name, $remarks, $lgdcode){
        $query = "INSERT INTO `malmatta_data_entry`(`period`, `village_name`, `ward_no`, `road_name`, `malmatta_no`, `city_survey_no`, `group_no`, `washroom_available`, `owner_name`, `wife_name`, `occupant_name`, `remarks`, `lgdcode`) VALUES ('$period', '$village_name', '$ward_no', '$road_name', '$malmatta_no', '$city_survey_no', '$group_no', '$washroom_available', '$owner_name', '$wife_name', '$occupant_name', '$remarks', '$lgdcode')";
        $result = mysqli_query($this->db, $query);
        if($result){
            return mysqli_insert_id($this->db); 
        }
        return $result;
    }

    public function getLastMalmattaDataEntryId(){
        $query = "SELECT MAX(`id`) as `id` FROM `malmatta_data_entry`";
        $result = mysqli_query($this->db, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['id'];
    }
    public function getMalmattaDataEntryById($id, $lgdcode){
        $query = "SELECT *, mde.`id` as `malmatta_id`, mde.`malmatta_no` as 'malmatta_number', nno.`person_name` as `owner_name`, nno1.`person_name` as `wife_name`, nno2.`person_name` as `occupant_name` FROM `malmatta_data_entry` mde
                    Left Join malmatta_property_info mpi on mde.`id` = mpi.`malmatta_id`
                    left join period_details pd on mde.`period` = pd.`id`
                    left join malmatta_water_tax mw on mde.`id` = mw.`malmatta_id`
                    left join road_details rd on mde.`road_name` = rd.`id`
                    left join ward_details wd on mde.`ward_no`= wd.`id`
                    left join new_name nno on mde.`owner_name` = nno.`id`
                    left join new_name nno1 on mde.`wife_name` = nno1.`id`
                    left join new_name nno2 on mde.`occupant_name` = nno2.`id`
                    Where mde.`id` = '$id' and mde.`lgdcode` = '$lgdcode' ;";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateMalmattaDataEntry($id,$period, $village_name, $ward_no, $road_name, $malmatta_no, $city_survey_no, $group_no, $washroom_available, $owner_name, $wife_name, $occupant_name, $remarks){
        $query = "UPDATE `malmatta_data_entry` SET `period`='$period', `village_name`='$village_name', `ward_no`='$ward_no', `road_name`='$road_name', `malmatta_no`='$malmatta_no', `city_survey_no`='$city_survey_no', `group_no`='$group_no', `washroom_available`='$washroom_available', `owner_name`='$owner_name', `wife_name`='$wife_name', `occupant_name`='$occupant_name', `remarks`='$remarks' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function deleteMalmattaDataEntry($id){
        $query = "DELETE FROM `malmatta_data_entry` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function approveMalmattaDataEntry($id){
        $query = "UPDATE `malmatta_data_entry` SET `approved`='1' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function verifyMalmattaDataEntry($id){
        $query = "UPDATE `malmatta_data_entry` SET `verified`='1' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    // malmatta_property_info

    public function getMalmattaPropertyInfo(){
        $query = "SELECT * FROM `malmatta_property_info`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addMalmattaPropertyInfo($malmatta_id, $directions, $tax_exempt, $property_use, $property_tax_type, $redirecconar_parts, $construction_year_type, $construction_year, $floor, $measuring_unit, $lenght, $width, $area, $malmatta_use){
        $query = "INSERT INTO `malmatta_property_info`(`malmatta_id`, `directions`, `tax_exempt`, `property_use`, `property_tax_type`, `redirecconar_parts`, `construction_year_type`, `construction_year`, `floor`, `measuring_unit`, `lenght`, `width`, `area`, `malmatta_use`) VALUES ('$malmatta_id', '$directions', '$tax_exempt', '$property_use', '$property_tax_type', '$redirecconar_parts', '$construction_year_type', '$construction_year', '$floor', '$measuring_unit', '$lenght', '$width', '$area', '$malmatta_use')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getMalmattaPropertyInfoById($id){
        $query = "SELECT * FROM `malmatta_property_info` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateMalmattaPropertyInfo($id,$malmatta_id, $directions, $tax_exempt, $property_use, $property_tax_type, $redirecconar_parts, $construction_year_type, $construction_year, $floor, $measuring_unit, $lenght, $width, $area, $malmatta_use){
        $query = "UPDATE `malmatta_property_info` SET `malmatta_id`='$malmatta_id', `directions`='$directions', `tax_exempt`='$tax_exempt', `property_use`='$property_use', `property_tax_type`='$property_tax_type', `redirecconar_parts`='$redirecconar_parts', `construction_year_type`='$construction_year_type', `construction_year`='$construction_year', `floor`='$floor', `measuring_unit`='$measuring_unit', `lenght`='$lenght', `width`='$width', `area`='$area', `malmatta_use`='$malmatta_use' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    

    public function deleteMalmattaPropertyInfo($id){
        $query = "DELETE FROM `malmatta_property_info` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getMalmattaWithProperties() {
    $query = "
        SELECT 
            *, 
            mpi.id AS property_id,
            mpi.directions, 
            mpi.tax_exempt, 
            mpi.property_use, 
            mpi.property_tax_type, 
            mpi.redirecconar_parts, 
            mpi.construction_year_type, 
            mpi.construction_year, 
            mpi.floor, 
            mpi.measuring_unit, 
            mpi.lenght, 
            mpi.width, 
            mpi.area,
             mde.`id` as `malmatta_id`, mde.`malmatta_no` as 'malmatta_number', nno.`person_name` as `owner_name`, nno1.`person_name` as `wife_name`, nno2.`person_name` as `occupant_name`
        FROM malmatta_data_entry mde
        Left Join malmatta_property_info mpi on mde.`id` = mpi.`malmatta_id`
                    left join period_details pd on mde.`period` = pd.`id`
                    left join malmatta_water_tax mw on mde.`id` = mw.`malmatta_id`
                    left join road_details rd on mde.`road_name` = rd.`id`
                    left join ward_details wd on mde.`ward_no`= wd.`id`
                    left join new_name nno on mde.`owner_name` = nno.`id`
                    left join new_name nno1 on mde.`wife_name` = nno1.`id`
                    left join new_name nno2 on mde.`occupant_name` = nno2.`id`
    ";

    $result = mysqli_query($this->db, $query);
    if (!$result) {
        return []; // or handle error
    }

    $malmattas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id']; // malmatta id

        if (!isset($malmattas[$id])) {
            $malmattas[$id] = [
                'malmatta_id' => $id,
                'period' => $row['period'],
                'village_name' => $row['village_name'],
                'ward_no' => $row['ward_no'],
                'road_name' => $row['road_name'],
                'malmatta_no' => $row['malmatta_no'],
                'city_survey_no' => $row['city_survey_no'],
                'group_no' => $row['group_no'],
                'washroom_available' => $row['washroom_available'],
                'owner_name' => $row['owner_name'],
                'wife_name' => $row['wife_name'],
                'occupant_name' => $row['occupant_name'],
                'remarks' => $row['remarks'],
                'lgdcode' => $row['lgdcode'],
                'properties' => []
            ];
        }

        // If property info exists
        if (!empty($row['property_id'])) {
            $malmattas[$id]['properties'][] = [
                'property_id' => $row['property_id'],
                'directions' => $row['directions'],
                'tax_exempt' => $row['tax_exempt'],
                'property_use' => $row['property_use'],
                'property_tax_type' => $row['property_tax_type'],
                'redirecconar_parts' => $row['redirecconar_parts'],
                'construction_year_type' => $row['construction_year_type'],
                'construction_year' => $row['construction_year'],
                'floor' => $row['floor'],
                'measuring_unit' => $row['measuring_unit'],
                'lenght' => $row['lenght'],
                'width' => $row['width'],
                'area' => $row['area']
            ];
        }
    }

    return array_values($malmattas);
}
    public function getMalmattaWithPropertiesWithId($id, $lgdcode) {
    $query = "
       SELECT 
            *, 
            mpi.id AS property_id,
            mpi.directions, 
            mpi.tax_exempt, 
            mpi.property_use, 
            mpi.property_tax_type, 
            mpi.redirecconar_parts, 
            mpi.construction_year_type, 
            mpi.construction_year, 
            mpi.floor, 
            mpi.measuring_unit, 
            mpi.lenght, 
            mpi.width, 
            mpi.area,
             mde.`id` as `malmatta_id`, mde.`malmatta_no` as 'malmatta_number', nno.`person_name` as `owner_name`, nno1.`person_name` as `wife_name`, nno2.`person_name` as `occupant_name`
        FROM malmatta_data_entry mde
        Left Join malmatta_property_info mpi on mde.`id` = mpi.`malmatta_id`
                    left join period_details pd on mde.`period` = pd.`id`
                    left join malmatta_water_tax mw on mde.`id` = mw.`malmatta_id`
                    left join road_details rd on mde.`road_name` = rd.`id`
                    left join ward_details wd on mde.`ward_no`= wd.`id`
                    left join new_name nno on mde.`owner_name` = nno.`id`
                    left join new_name nno1 on mde.`wife_name` = nno1.`id`
                    left join new_name nno2 on mde.`occupant_name` = nno2.`id`
                    left join readyrec_info r on mpi.`redirecconar_parts` = r.`readyrec_type`
        WHERE mde.id = '$id'
        AND mde.lgdcode = '$lgdcode'
        AND mde.approved = '1'
    ";

    $result = mysqli_query($this->db, $query);
    if (!$result) {
        return []; // or handle error
    }
     $milkatTaxInfo = $this->getMilkatTaxInfoDarCons($_SESSION['district_code']);
    if(mysqli_num_rows($milkatTaxInfo) > 0){
        $milkatTaxInfo = mysqli_fetch_assoc($milkatTaxInfo);
    }else{
        $milkatTaxInfo = [];
    }

    $milkatTaxFixed = $this->getMilkatTaxInfoDarFixed($_SESSION['district_code']); 
    if(mysqli_num_rows($milkatTaxFixed) > 0){
        $milkatTaxFixed = mysqli_fetch_assoc($milkatTaxFixed);
    }else{
        $milkatTaxFixed = [];
    }

    $malmattas = [];
    $total_bhandavali = 0;
    $building_total_value = 0;
    $padsar_total_value = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id']; // malmatta id
        $malmatta_use_tax = [
            "रहिवाशी" => 1,
            "वाणिज्य/व्यापार" => 1.2,
            "औद्योगिक" => 1.5
        ];
        if (!isset($malmattas[$id])) {
            $malmattas[$id] = [
                'malmatta_id' => $id,
                'period' => $row['period'],
                'village_name' => $row['village_name'],
                'ward_no' => $row['ward_no'],
                'road_name' => $row['road_name'],
                'malmatta_no' => $row['malmatta_no'],
                'city_survey_no' => $row['city_survey_no'],
                'group_no' => $row['group_no'],
                'washroom_available' => $row['washroom_available'],
                'owner_name' => $row['owner_name'],
                'wife_name' => $row['wife_name'],
                'occupant_name' => $row['occupant_name'],
                'remarks' => $row['remarks'],
                'lgdcode' => $row['lgdcode'],
                'ward_name' => $row['ward_name'],
                'properties' => [],
                'readyrec_type' => $row['readyrec_type'],
                
            ];
        }

        // If property info exists
        if (!empty($row['property_id'])) {
            $year = $row['construction_year'];
            $group = (in_array($row['property_use'], $this->propertyUseGroupA)? $this->ghasaraDarGroupA : (
                (in_array($row['property_use'], $this->propertyUseGroupB)? $this->ghasaraDarGroupB : [1,1,1,1,1,1,1,1,1])
            ));
            $ghasaraTax = 100;
           if($year> 0 && $year <= 2){
                $ghasaraTax = $group[0];
           }else if($year >2 && $year <= 5){
                $ghasaraTax = $group[1];
           }
              else if($year >5 && $year <= 10){
                 $ghasaraTax = $group[2];
              }else if($year >10 && $year <= 20){
                 $ghasaraTax = $group[3];
              }else if($year >20 && $year <= 30){
                 $ghasaraTax = $group[4];
                }else if($year >30 && $year <= 40){
                    $ghasaraTax = $group[5];
                }else if($year >40 && $year <= 50){
                    $ghasaraTax = $group[6];
                }else if($year >50 && $year <= 60){
                    $ghasaraTax = $group[7];
                }else if($year >60){
                    $ghasaraTax = $group[8];
                }
                $area = ($row['measuring_unit'] == 'foot'? $row['area']/10.76 : $row['area']);
                $areaInFoot = ($row['measuring_unit'] == 'foot'? $row['area'] : $row['area']*10.76);

                $constructionTax = $milkatTaxInfo[$this->milkatObject[$row['property_use']]];
                $milkatFixedTax = $milkatTaxFixed[$this->milkatObject[$row['property_use']]];
                $bharank = $malmatta_use_tax[$row["malmatta_use"]];
                $bhandavali = $area * $row['yearly_tax'] + $area * $constructionTax * ($ghasaraTax/100) * $bharank;
                $building_value = ($bhandavali*$milkatFixedTax)/100;
                $total_bhandavali += $bhandavali;
                if($row['property_use'] == 'पडसर/खुली जागा'){
                    $padsar_total_value += $building_value; 
                }else{
                    $building_total_value += $building_value;
                }
            $malmattas[$id]['properties'][] = [
                'property_id' => $row['property_id'],
                'directions' => $row['directions'],
                'tax_exempt' => $row['tax_exempt'],
                'property_use' => $row['property_use'],
                'property_tax_type' => $row['property_tax_type'],
                'redirecconar_parts' => $row['redirecconar_parts'],
                'construction_year_type' => $row['construction_year_type'],
                'construction_year' => $row['construction_year'],
                'floor' => $row['floor'],
                'measuring_unit' => $row['measuring_unit'],
                'lenght' => $row['lenght'],
                'width' => $row['width'],
                'areaInMt' => round($area,2),
                'areaInFoot' => round($areaInFoot,2),
                'yearly_tax' => $row['yearly_tax'],
                'construction_tax' => $constructionTax,
                'ghasara_tax'=> $ghasaraTax/100,
                "bharank"=>$bharank,
                "malmatta_use"=>$row["malmatta_use"],
                "bhandavali"=>round($bhandavali,2),
                "building_value" => round($building_value,2),
                "milkat_fixed_tax" => $milkatFixedTax,
            ];
        }
        $malmattas[$id]['total_bhandavali'] = round($total_bhandavali);
        $malmattas[$id]['building_total_value'] = round($building_total_value);
        $malmattas[$id]['padsar_total_value'] = round($padsar_total_value);
    }

    return array_values($malmattas);
}

public function getMalmattaDetailsAll($malmattaId, $village){
    

  
$response = ['success' => false];
$milkatObject = [
    "आर सी सी पद्धतीचे बांधकाम" => "rcc",
    "इतर पक्के घर (दगड विटांचे चुना किंवा सिमेंटचे घर)" =>"itar_pakke_ghar",
    "अर्ध पक्के घर (दगड विटांचे मातीचे घर)"=> "ardha_pakke_ghar",
    "कच्चे घर (झोपडी किंवा मातीचे घर)" => "kache_ghar",
    "पडसर/खुली जागा" => "padsar",
    "मनोरा तळ घर"=> "manora_type_ghar",
    "मनोरा खुली जागा सर्वसाधारण किंवा डोंगराळ आदिवसी क्षेत्र असलेल्या ग्रामपंचायती"=>"manora_khuli_jaga_sarvasadharan",
    "मनोरा खुली जागा महानगरपालिका किंवा नगरपालिका यांच्या लगतच्या ग्रामपंचायती"=> "manora_khuli_jaga_mnc"   
];
if ($malmattaId) {
    // Get full malmatta entry with properties + water tax
    $malmattaData = $this->getMalmattaWithPropertiesWithId($malmattaId, $_SESSION['district_code']);
    
    // print_r($malmattaData);
    if ($malmattaData) {
        $response['success'] = true;
        $response['info'] = $malmattaData;

        // ✅ Extract total area from properties
        $totalArea = 0;
        $malmattaEntry = $malmattaData[0] ?? null;

if ($malmattaEntry && isset($malmattaEntry['properties'])) {
    foreach ($malmattaEntry['properties'] as $prop) {
        $totalArea += (int) ($prop['areaInFoot'] ?? 0);
    }
}


       
        $taxQuery = "SELECT * FROM tax_info WHERE lgdcode = '{$_SESSION['district_code']}'";
        $taxResult = $this->db->query($taxQuery);

        $reedirecQuery = "SELECT * FROM readyrec_info WHERE revenue_village = '$village'";
        $reedirecResult = $this->db->query($reedirecQuery);
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
        $response["water_tariff"] = $this->getWaterTariffByDrainageType("सामान्य पाणीपट्टी", $_SESSION['district_code']);
    }
}

// header('Content-Type: application/json');
return $response;
}


    //malmatta_water_tax

    public function getMalmattaWaterTax(){
        $query = "SELECT * FROM `malmatta_water_tax`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addMalmattaWaterTax($malmatta_id, $water_usage_type, $no_of_taps, $tap_width, $tap_owner_name){
        $query = "INSERT INTO `malmatta_water_tax`(`malmatta_id`, `water_usage_type`, `no_of_taps`, `tap_width`, `tap_owner_name`) VALUES ('$malmatta_id', '$water_usage_type', '$no_of_taps', '$tap_width', '$tap_owner_name')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getMalmattaWaterTaxById($id){
        $query = "SELECT * FROM `malmatta_water_tax` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function updateMalmattaWaterTax($id,$malmatta_id, $water_usage_type, $no_of_taps, $tap_width, $tap_owner_name){
        $query = "UPDATE `malmatta_water_tax` SET `malmatta_id`='$malmatta_id', `water_usage_type`='$water_usage_type', `no_of_taps`='$no_of_taps', `tap_width`='$tap_width', `tap_owner_name`='$tap_owner_name' WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }


    //lgdtable

    public function getLgdTable(){
        $query = "SELECT * FROM `lgdtable`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getUniqueStates(){
        $query = "SELECT DISTINCT `state` FROM `lgdtable`";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getUniqueDistricts($state){
        $query = "SELECT DISTINCT `District_Code`, `District_Name` FROM `lgdtable` WHERE `state` = '$state'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function getVillagesWithDistrict($district_code){
        $query = "SELECT DISTINCT `Village_Code`, `Village_Name`,`District_Code` FROM `lgdtable` WHERE `District_Code` = '$district_code'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    // milkat tax info

    public function getMilkatTaxInfoDarMin($lgd_code){
        $query = "SELECT * FROM `milkat_tax_info` where `district_code` = '$lgd_code' and `dar` = 'min'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getMilkatTaxInfoDarMax($lgd_code){
        $query = "SELECT * FROM `milkat_tax_info` where `district_code` = '$lgd_code' and `dar` = 'max'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getMilkatTaxInfoDarCons($lgd_code){
        $query = "SELECT * FROM `milkat_tax_info` where `district_code` = '$lgd_code' and `dar` = 'construction'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getMilkatTaxInfoDarFixed($lgd_code){
        $query = "SELECT * FROM `milkat_tax_info` where `district_code` = '$lgd_code' and `dar` = 'fixed'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function addMilkatTaxInfo($district_code, $dar, $kacche_ghar, $ardha_pakke_ghar, $padsar, $itar_pakke_ghar,$rcc,$manora_type_ghar,$manora_khuli_jaga_sarvasadharan,$manora_khuli_jaga_mnc){
        $query = "INSERT INTO `milkat_tax_info`(`district_code`, `dar`, `kacche_ghar`, `ardha_pakke_ghar`, `padsar`, `itar_pakke_ghar`, `rcc`, `manora_type_ghar`, `manora_khuli_jaga_sarvasadharan`, `manora_khuli_jaga_mnc`) VALUES ('$district_code', '$dar', '$kacche_ghar', '$ardha_pakke_ghar', '$padsar', '$itar_pakke_ghar', '$rcc', '$manora_type_ghar', '$manora_khuli_jaga_sarvasadharan', '$manora_khuli_jaga_mnc')";
        // $query = "INSERT INTO `milkat_tax_info`(`district_code`, `dar`, `min_rate`, `max_rate`, `fixed_rate`, `construction_rate`) VALUES ('$district_code', '$dar', '$min_rate', '$max_rate', '$fixed_rate', '$construction_rate')";
        $result = mysqli_query($this->db, $query);
        return $result;
    }

    public function isMilkatTaxInfoExists($district_code, $dar) {
        $query = "SELECT * FROM `milkat_tax_info` WHERE `district_code` = '$district_code' and `dar` = '$dar'";
        $result = mysqli_query($this->db, $query);
        return mysqli_num_rows($result) > 0;
    }
    
    //bank master

    function addBank($data) {
    // Check if district code exists in session
    if (!isset($_SESSION['district_code'])) {
        return ['success' => false, 'message' => 'District code not found in session'];
    }
    
    // Validate data
    $errors = [];
    if (empty($data['plan_name'])) $errors[] = 'Plan name is required';
    if (empty($data['bank_name'])) $errors[] = 'Bank name is required';
    if (empty($data['bank_branch'])) $errors[] = 'Bank branch is required';
    if (empty($data['bank_address'])) $errors[] = 'Bank address is required';
    if (empty($data['bank_no'])) $errors[] = 'Account number is required';
    if (empty($data['bank_ifsc_code'])) $errors[] = 'IFSC code is required';
    
    if (!empty($errors)) {
        return ['success' => false, 'message' => 'Validation failed', 'errors' => $errors];
    }
    
    // Check if already 5 banks exist for this plan
    $checkSql = "SELECT COUNT(*) as count FROM bank_master 
                 WHERE plan_name = ? AND district_code = ?";
    $stmt = $this->db->prepare($checkSql);
    $stmt->bind_param("ss", $data['plan_name'], $_SESSION['district_code']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] >= 5) {
        return ['success' => false, 'message' => 'You can only add 5 banks per plan'];
    }
    
    // Insert new bank
    $sql = "INSERT INTO bank_master 
            (plan_name, bank_name, bank_branch, bank_address, account_no, ifsc_code, district_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sssssss", 
        $data['plan_name'],
        $data['bank_name'],
        $data['bank_branch'],
        $data['bank_address'],
        $data['bank_no'],
        $data['bank_ifsc_code'],
        $_SESSION['district_code']
    );
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Bank added successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to add bank: ' . $this->db->error];
    }
}

// Get all banks for current district
function getBanks() {
    if (!isset($_SESSION['district_code'])) {
        return ['success' => false, 'message' => 'District code not found in session'];
    }
    
    $sql = "SELECT * FROM bank_master WHERE district_code = ? ORDER BY plan_name, bank_name";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $_SESSION['district_code']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $banks = [];
    while ($row = $result->fetch_assoc()) {
        $banks[] = $row;
    }
    
    return ['success' => true, 'data' => $banks];
}

// Update bank
function updateBank( $id, $data) {
    // Validate data
    $errors = [];
    if (empty($data['plan_name'])) $errors[] = 'Plan name is required';
    if (empty($data['bank_name'])) $errors[] = 'Bank name is required';
    if (empty($data['bank_branch'])) $errors[] = 'Bank branch is required';
    if (empty($data['bank_address'])) $errors[] = 'Bank address is required';
    if (empty($data['bank_no'])) $errors[] = 'Account number is required';
    if (empty($data['bank_ifsc_code'])) $errors[] = 'IFSC code is required';
    
    if (!empty($errors)) {
        return ['success' => false, 'message' => 'Validation failed', 'errors' => $errors];
    }
    
    $sql = "UPDATE bank_master SET 
            plan_name = ?,
            bank_name = ?,
            bank_branch = ?,
            bank_address = ?,
            account_no = ?,
            ifsc_code = ?
            WHERE id = ? AND district_code = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("ssssssis", 
        $data['plan_name'],
        $data['bank_name'],
        $data['bank_branch'],
        $data['bank_address'],
        $data['bank_no'],
        $data['bank_ifsc_code'],
        $id,
        $_SESSION['district_code']
    );
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Bank updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to update bank: ' . $this->db->error];
    }
}

// Delete bank
function deleteBank( $id) {
    if (!isset($_SESSION['district_code'])) {
        return ['success' => false, 'message' => 'District code not found in session'];
    }
    
    $sql = "DELETE FROM bank_master WHERE id = ? AND district_code = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("is", $id, $_SESSION['district_code']);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Bank deleted successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to delete bank: ' . $this->db->error];
    }
}

// checkbooks

public function getCheckbooks($district_code) {
    $sql = "SELECT * FROM checkbooks WHERE district_code = ? ORDER BY date DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $district_code);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Get bank name by ID
 */
public function getBankName($bank_id) {
    $sql = "SELECT bank_name FROM bank_master WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $bank_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bank = $result->fetch_assoc();
    return $bank ? $bank['bank_name'] : 'Unknown';
}

/**
 * Add new checkbook
 */
public function addCheckbook($data) {
    $sql = "INSERT INTO checkbooks 
            (plan_name, bank_id, checkbook_no, first_check_no, check_no, last_check_no, date, district_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sisssiss", 
        $data['plan_name'],
        $data['bank_name'],
        $data['checkbook_no'],
        $data['first_check_no'],
        $data['check_no'],
        $data['last_check_no'],
        $data['date'],
        $data['district_code']
    );
    
    return $stmt->execute();
}

/**
 * Update checkbook
 */
public function updateCheckbook($id, $data) {
    $sql = "UPDATE checkbooks SET 
            plan_name = ?,
            bank_id = ?,
            checkbook_no = ?,
            first_check_no = ?,
            check_no = ?,
            last_check_no = ?,
            date = ?
            WHERE id = ? AND district_code = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sisssissi", 
        $data['plan_name'],
        $data['bank_name'],
        $data['checkbook_no'],
        $data['first_check_no'],
        $data['check_no'],
        $data['last_check_no'],
        $data['date'],
        $id,
        $data['district_code']
    );
    
    return $stmt->execute();
}

/**
 * Delete checkbook
 */
public function deleteCheckbook($id, $district_code) {
    $sql = "DELETE FROM checkbooks WHERE id = ? AND district_code = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("is", $id, $district_code);
    return $stmt->execute();
}

// Materials

// functions.php

/**
 * Get all materials for current district
 */
public function getMaterials($district_code) {
    $sql = "SELECT * FROM materials WHERE district_code = ? ORDER BY material_name";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $district_code);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Add new material
 */
public function addMaterial($data) {
    $sql = "INSERT INTO materials (material_name, district_code) VALUES (?, ?)";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("ss", $data['material_name'], $data['district_code']);
    return $stmt->execute();
}

/**
 * Update material
 */
public function updateMaterial($id, $data) {
    $sql = "UPDATE materials SET material_name = ? WHERE id = ? AND district_code = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sis", $data['material_name'], $id, $data['district_code']);
    return $stmt->execute();
}

/**
 * Delete material
 */
public function deleteMaterial($id, $district_code) {
    $sql = "DELETE FROM materials WHERE id = ? AND district_code = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("is", $id, $district_code);
    return $stmt->execute();
}

//Year Start Remaining

// functions.php

/**
 * Get year start balances for current district
 */
public function getYearStartBalances($district_code) {
    $sql = "SELECT * FROM year_start_balances WHERE district_code = ? ORDER BY financial_year DESC, plan_name";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $district_code);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Add new year start balance
 */
public function addYearStartBalance($data) {
    $sql = "INSERT INTO year_start_balances 
            (balance_type, financial_year, plan_name, bank_id, post_name, post_branch, 
             account_no, ifsc_code, amount, district_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sssissssds", 
        $data['balance_type'],
        $data['financial_year'],
        $data['plan_name'],
        $data['bank_id'],
        $data['post_name'],
        $data['post_branch'],
        $data['account_no'],
        $data['ifsc_code'],
        $data['amount'],
        $data['district_code']
    );
    
    return $stmt->execute();
}

/**
 * Update year start balance
 */
public function updateYearStartBalance($id, $data) {
    $sql = "UPDATE year_start_balances SET 
            balance_type = ?,
            financial_year = ?,
            plan_name = ?,
            bank_id = ?,
            post_name = ?,
            post_branch = ?,
            account_no = ?,
            ifsc_code = ?,
            amount = ?
            WHERE id = ? AND district_code = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sssissssdis", 
        $data['balance_type'],
        $data['financial_year'],
        $data['plan_name'],
        $data['bank_id'],
        $data['post_name'],
        $data['post_branch'],
        $data['account_no'],
        $data['ifsc_code'],
        $data['amount'],
        $id,
        $data['district_code']
    );
    
    return $stmt->execute();
}

/**
 * Delete year start balance
 */
public function deleteYearStartBalance($id, $district_code) {
    $sql = "DELETE FROM year_start_balances WHERE id = ? AND district_code = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("is", $id, $district_code);
    return $stmt->execute();
}

// functions.php

/**
 * Get property verifications for current district
 */
public function getPropertyVerifications($district_code) {
    $sql = "SELECT * FROM property_verifications WHERE district_code = ? ORDER BY verification_date DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $district_code);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Add new property verification
 */
public function addPropertyVerification($data) {
    $sql = "INSERT INTO property_verifications 
            (formula, village_code, period_id, malmatta_id, ward_no, owner_name, 
             road_name, group_no, occupant_name, previous_tax, building_tax, 
             light_tax, health_tax, water_tax, padsar_tax, capital_value, 
             total_tax, discount, final_tax, verification_date, district_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("ssiisssssddddddddddss", 
        $data['formula'],
        $data['village_code'],
        $data['period_id'],
        $data['malmatta_id'],
        $data['ward_no'],
        $data['owner_name'],
        $data['road_name'],
        $data['group_no'],
        $data['occupant_name'],
        $data['previous_tax'],
        $data['building_tax'],
        $data['light_tax'],
        $data['health_tax'],
        $data['water_tax'],
        $data['padsar_tax'],
        $data['capital_value'],
        $data['total_tax'],
        $data['discount'],
        $data['final_tax'],
        $data['verification_date'],
        $data['district_code']
    );
    
    return $stmt->execute();
}

/**
 * Update property verification
 */
public function updatePropertyVerification($id, $data) {
    $sql = "UPDATE property_verifications SET 
            formula = ?,
            village_code = ?,
            period_id = ?,
            malmatta_id = ?,
            ward_no = ?,
            owner_name = ?,
            road_name = ?,
            group_no = ?,
            occupant_name = ?,
            previous_tax = ?,
            building_tax = ?,
            light_tax = ?,
            health_tax = ?,
            water_tax = ?,
            padsar_tax = ?,
            capital_value = ?,
            total_tax = ?,
            discount = ?,
            final_tax = ?,
            verification_date = ?
            WHERE id = ? AND district_code = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("ssiisssssddddddddddssi", 
        $data['formula'],
        $data['village_code'],
        $data['period_id'],
        $data['malmatta_id'],
        $data['ward_no'],
        $data['owner_name'],
        $data['road_name'],
        $data['group_no'],
        $data['occupant_name'],
        $data['previous_tax'],
        $data['building_tax'],
        $data['light_tax'],
        $data['health_tax'],
        $data['water_tax'],
        $data['padsar_tax'],
        $data['capital_value'],
        $data['total_tax'],
        $data['discount'],
        $data['final_tax'],
        $data['verification_date'],
        $id,
        $data['district_code']
    );
    
    return $stmt->execute();
}

/**
 * Get property details for verification
 */
public function getPropertyDetailsForVerification($villageCode, $periodId, $malmattaId) {
    // Get basic property info
    $sql = "SELECT * FROM malmatta_data_entry 
            WHERE id = ? AND village_code = ? AND period_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("iss", $malmattaId, $villageCode, $periodId);
    $stmt->execute();
    $result = $stmt->get_result();
    $info = $result->fetch_assoc();
    
    if (!$info) {
        return ['success' => false, 'message' => 'Property not found'];
    }
    
    // Get property components
    $sql = "SELECT * FROM malmatta_property_details 
            WHERE malmatta_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $malmattaId);
    $stmt->execute();
    $properties = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Get tax rates
    $sql = "SELECT * FROM tax_rates WHERE district_code = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $info['district_code']);
    $stmt->execute();
    $taxRates = $stmt->get_result()->fetch_assoc();
    
    // Get water tariff
    $sql = "SELECT * FROM water_tariff WHERE district_code = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $info['district_code']);
    $stmt->execute();
    $waterTariff = $stmt->get_result()->fetch_assoc();
    
    return [
        'success' => true,
        'info' => $info,
        'properties' => $properties,
        'tax_rates' => $taxRates,
        'water_tariff' => $waterTariff
    ];
}
}
?>