<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

header('Content-Type: application/json');
   $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);
// Initialize response
$response = [
    'success' => false,
    'message' => 'Unknown error occurred'
];

try {
    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get the logged-in user ID from session
    $created_by = $_SESSION['user_id'] ?? null;

    // Process and sanitize input data
    $data = [
        'malamatta_kramanak' => $_POST['malamatta_kramanak'] ?? '',
        'ward_kramanak' => $_POST['ward_kramanak'] ?? '',
        'kar_denaryache_nav' => $_POST['kar_denaryache_nav'] ?? '',
        'vasul_dinank' => $_POST['vasul_dinank'] ?? '',
        'pustak_kramanak' => $_POST['pustak_kramanak']."/".$_POST['pavati_kramanak'] ?? '',
        'pavati_kramanak' => $_POST['pavati_kramanak'] ?? '',
        'payment_type' => $_POST['paymentType'] ?? 'cash',
        'bank_name' => $_POST['bank_name'] ?? null,
        'account_holder_name' => $_POST['account_holder_name'] ?? null,
        'cheque_number' => $_POST['cheque_number'] ?? null,
        'check_date' => $_POST['check_date'] ?? null,
        'neft_rtgs_ref_1' => $_POST['neft_rtgs_ref_1'] ?? null,
        'neft_rtgs_ref_2' => $_POST['neft_rtgs_ref_2'] ?? null,
        'total_building_tax' => $_POST['total_vasul_building_tax'] ?? 0,

        'previous_mangani_building_tax' => $_POST['previous_mangani_building_tax'] ?? 0,
        'previous_mangani_health_tax' => $_POST['previous_mangani_health_tax'] ?? 0,
        'previous_mangani_divabatti_tax' => $_POST['previous_mangani_divabatti_tax'] ?? 0,
        'previous_mangani_panniyojana_tax' => $_POST['previous_mangani_panniyojana_tax'] ?? 0,
        'previous_mangani_padsar_tax' => $_POST['previous_mangani_padsar_tax'] ?? 0,
        'previous_mangani_dand_tax' => $_POST['previous_mangani_dand_tax'] ?? 0,
        'previous_mangani_sut_tax' => $_POST['previous_mangani_sut_tax'] ?? 0,
        'previous_mangani_total_tax' => $_POST['previous_mangani_total_tax'] ?? 0,
        
        'current_mangani_building_tax' => $_POST['current_mangani_building_tax'] ?? 0,
        'current_mangani_health_tax' => $_POST['current_mangani_health_tax'] ?? 0,
        'current_mangani_divabatti_tax' => $_POST['current_mangani_divabatti_tax'] ?? 0,
        'current_mangani_panniyojana_tax' => $_POST['current_mangani_panniyojana_tax'] ?? 0,
        'current_mangani_padsar_tax' => $_POST['current_mangani_padsar_tax'] ?? 0,
        'current_mangani_dand_tax' => $_POST['current_mangani_dand_tax'] ?? 0,
        'current_mangani_sut_tax' => $_POST['current_mangani_sut_tax'] ?? 0,
        'current_mangani_total_tax' => $_POST['current_mangani_total_tax'] ?? 0,

         'previous_vasul_building_tax' => $_POST['previous_vasul_building_tax'] ?? 0,
        'previous_vasul_health_tax' => $_POST['previous_vasul_health_tax'] ?? 0,
        'previous_vasul_divabatti_tax' => $_POST['previous_vasul_divabatti_tax'] ?? 0,
        'previous_vasul_panniyojana_tax' => $_POST['previous_vasul_panniyojana_tax'] ?? 0,
        'previous_vasul_padsar_tax' => $_POST['previous_vasul_padsar_tax'] ?? 0,
        'previous_vasul_dand_tax' => $_POST['previous_vasul_dand_tax'] ?? 0,
        'previous_vasul_sut_tax' => $_POST['previous_vasul_sut_tax'] ?? 0,
        'previous_vasul_total_tax' => $_POST['previous_vasul_total_tax'] ?? 0,
        
        'current_vasul_building_tax' => $_POST['current_vasul_building_tax'] ?? 0,
        'current_vasul_health_tax' => $_POST['current_vasul_health_tax'] ?? 0,
        'current_vasul_divabatti_tax' => $_POST['current_vasul_divabatti_tax'] ?? 0,
        'current_vasul_panniyojana_tax' => $_POST['current_vasul_panniyojana_tax'] ?? 0,
        'current_vasul_padsar_tax' => $_POST['current_vasul_padsar_tax'] ?? 0,
        'current_vasul_dand_tax' => $_POST['current_vasul_dand_tax'] ?? 0,
        'current_vasul_sut_tax' => $_POST['current_vasul_sut_tax'] ?? 0,
        'current_vasul_total_tax' => $_POST['current_vasul_total_tax'] ?? 0,
        
        'total_mangani_building_tax' => $_POST['total_mangani_building_tax'] ?? 0,
        'total_health_tax' => $_POST['total_vasul_health_tax'] ?? 0,
        'total_mangani_health_tax' => $_POST['total_mangani_health_tax'] ?? 0,
        'total_divabatti_tax' => $_POST['total_vasul_divabatti_tax'] ?? 0,
        'total_mangani_divabatti_tax' => $_POST['total_mangani_divabatti_tax'] ?? 0,
        'total_panniyojana_tax' => $_POST['total_vasul_panniyojana_tax'] ?? 0,
        'total_mangani_panniyojana_tax' => $_POST['total_mangani_panniyojana_tax'] ?? 0,
        'total_padsar_tax' => $_POST['total_vasul_padsar_tax'] ?? 0,
        'total_mangani_padsar_tax' => $_POST['total_mangani_padsar_tax'] ?? 0,
        'total_dand_tax' => $_POST['total_vasul_dand_tax'] ?? 0,
        'total_mangani_dand_tax' => $_POST['total_mangani_dand_tax'] ?? 0,
        'total_sut_tax' => $_POST['total_vasul_sut_tax'] ?? 0,
        'total_mangani_sut_tax' => $_POST['total_mangani_sut_tax'] ?? 0,
        'total_amount' => $_POST['total_vasul_total_tax'] ?? 0,
        'total_mangani_total_tax' => $_POST['total_mangani_total_tax'] ?? 0,
        'created_by' => $created_by,
        'panchayat_code' => $_SESSION['panchayat_code'],
    ];



    $propertyVerification = $fun->getPropertyVerificationWithMalmattaId($_POST['malamatta_kramanak']);
    if(!$propertyVerification) {
        throw new Exception('Property verification not found for the given malmatta kramanak');
    }
    $property_verifications_data = [
        'building_tax' => abs($_POST['total_vasul_building_tax']- $propertyVerification['building_tax']),
        'health_tax' => abs($_POST['total_vasul_health_tax'] - $propertyVerification['health_tax']),
        'light_tax' => abs($_POST['total_vasul_divabatti_tax'] - $propertyVerification['light_tax']),
        'water_tax' => abs($_POST['total_vasul_panniyojana_tax'] - $propertyVerification['water_tax']),
        'padsar_tax' => abs($_POST['total_vasul_padsar_tax'] - $propertyVerification['padsar_tax']),
        'total_tax' => abs($_POST['total_vasul_total_tax'] - $propertyVerification['total_tax']),
        'final_tax' => abs($_POST['total_vasul_total_tax'] - $propertyVerification['final_tax'])
    ];

    // Validate required fields
    $requiredFields = [
        'malamatta_kramanak', 'vasul_dinank', 'pustak_kramanak', 'pavati_kramanak',
        'total_building_tax', 'total_health_tax', 'total_divabatti_tax',
        'total_panniyojana_tax', 'total_padsar_tax', 'total_dand_tax',
        'total_sut_tax', 'total_amount'
    ];

    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("Required field '$field' is missing or empty");
        }
    }

    // Convert date format if needed
    if (!empty($data['vasul_dinank'])) {
        $data['vasul_dinank'] = date('Y-m-d', strtotime($data['vasul_dinank']));
    }

    if (!empty($data['check_date'])) {
        $data['check_date'] = date('Y-m-d', strtotime($data['check_date']));
    }

    // Convert numeric fields to proper format
    $numericFields = [
        'total_building_tax', 'total_health_tax', 'total_divabatti_tax',
        'total_panniyojana_tax', 'total_padsar_tax', 'total_dand_tax',
        'total_sut_tax', 'total_amount'
    ];

    foreach ($numericFields as $field) {
        $data[$field] = (float) str_replace(',', '', $data[$field]);
    }

    // Check if payment type is valid
    $validPaymentTypes = ['cash', 'cheque', 'neft', 'rtgs', 'card'];
    if (!in_array($data['payment_type'], $validPaymentTypes)) {
        throw new Exception('Invalid payment type');
    }   
    print_r($data);


    $result = $fun->insertRecord( 'karvasuli_records', $data);
    
    if ($result) {
        print_r($property_verifications_data);
        $updatePropertyVerification = $fun->updateRecord('property_verifications', $property_verifications_data, 'malmatta_id="'.$data['malamatta_kramanak'].'"');
        if (!$updatePropertyVerification) {
            throw new Exception('Failed to update property verification');
        }
        $response = [
            'success' => true,
            'message' => 'Record saved successfully',
            'record_id' => $result
        ];
    } else {
        throw new Exception('Failed to save record to database');
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
 $_SESSION['message'] = "" . $response['message'];
        $_SESSION['message_type'] = $response['success'] ? "success" : "error";
header('Location: ../namuna10_dainandinkamkaj_gharpatti_karvasuli.php');