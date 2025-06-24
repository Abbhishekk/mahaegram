<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

/*
    capital_value => Bhandavali,
    building_tax => imarat kar,
    health_tax => arogya kar,
    light_tax => divya kar,
    water_tax => paani kar,
    padsar_tax => padsar kar,
    final_tax => ekun kar
*/

try {
    
    if (!isset($_SESSION['district_code'])) {
        throw new Exception('District code not found in session');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'formula' => $_POST['formula'] ?? '',
            'village_code' => $_POST['village_code'] ?? '',
            'period_id' => $_POST['period_id'] ?? '',
            'malmatta_id' => $_POST['malmatta_id'] ?? '',
            'ward_no' => $_POST['ward_no'] ?? '',
            'owner_name' => $_POST['owner_name'] ?? '',
            'road_name' => $_POST['road_name'] ?? '',
            'group_no' => $_POST['group_no'] ?? '',
            'occupant_name' => $_POST['occupant_name'] ?? '',
            'previous_tax' => $_POST['previous_tax'] ?? 0,
            'building_tax' => $_POST['building_tax'] ?? 0,
            'light_tax' => $_POST['light_tax'] ?? 0,
            'health_tax' => $_POST['health_tax'] ?? 0,
            'water_tax' => $_POST['water_tax'] ?? 0,
            'safai_tax' => $_POST['safai_tax'] ?? 0,
            'padsar_tax' => $_POST['padsar_tax'] ?? 0,
            'capital_value' => $_POST['capital_value'] ?? 0,
            'total_tax' => $_POST['total_tax'] ?? 0,
            'discount' => $_POST['discount'] ?? 0,
            'final_tax' => $_POST['final_tax'] ?? 0,
            'verification_date' => $_POST['verification_date'] ?? '',
            'district_code' => $_SESSION['district_code']
        ];
        print_r($data);
        // Validate required fields
        $errors = [];
        if (empty($data['village_code'])) $errors[] = 'गावाचे नाव आवश्यक आहे';
        if (empty($data['period_id'])) $errors[] = 'कालावधी आवश्यक आहे';
        if (empty($data['malmatta_id'])) $errors[] = 'मालमत्ता क्रमांक आवश्यक आहे';
        if (empty($data['verification_date'])) $errors[] = 'प्रमाणिकरण दिनांक आवश्यक आहे';
        
        if (!empty($errors)) {
            throw new Exception(implode('<br>', $errors));
        }
        
        if (!empty($_POST['verification_id'])) {
            // Update existing verification
            $id = (int)$_POST['verification_id'];
            $success = $fun->updatePropertyVerification($id, $data);
            $approveProperty = $fun->approveMalmattaDataEntry($_POST['malmatta_id']);
            if ($success) {
                $fun->verifyMalmattaDataEntry($data['malmatta_id']);
            }
            $message = $success ? 'प्रमाणिकरण यशस्वीरित्या अद्यतनित केले' : 'प्रमाणिकरण अद्यतनित करताना त्रुटी';
        } else {
            // Add new verification
            $success = $fun->addPropertyVerification($data);
             $approveProperty = $fun->approveMalmattaDataEntry($_POST['malmatta_id']);
            if ($success) {
                $fun->verifyMalmattaDataEntry($data['malmatta_id']);
            }
            $message = $success ? 'प्रमाणिकरण यशस्वीरित्या नोंदवले <a href="namuna9_varshikkamkaj_varshikkarmagni.php" class="btn btn-primary">वार्शिक कर मांगनी येथे जाण्यासाठी येथे क्लिक करा</a> ' : 'प्रमाणिकरण नोंदवताना त्रुटी';
        }
        
        if ($success) {
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = 'success';
        } else {
            throw new Exception($message);
        }
        
        header('Location: ../Form_Malmatta_N8.php');
        exit;
    }
    
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: ../Form_Malmatta_N8.php');
    exit;
}