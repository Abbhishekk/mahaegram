<?php
// api/jamacheckchi_sthiti.php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

header('Content-Type: application/json');
  $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);
$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate required fields
    $requiredFields = [
        'financial_year', 'plan_name', 'check_number', 
        'bank_deposited', 'check_status', 'pustak_kramanak'
    ];
    
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Required field '$field' is missing");
        }
    }

    // Prepare data for insertion
    $data = [
        'financial_year' => $_POST['financial_year'],
        'plan_name' => $_POST['plan_name'],
        'date' => $_POST['date'] ? date('Y-m-d', strtotime($_POST['date'])) : date('Y-m-d'),
        'checkbook_id' => $_POST['check_number'],
        'check_received_date' => $_POST['check_received_date'] ? date('Y-m-d', strtotime($_POST['check_received_date'])) : date('Y-m-d'),
        'bank_name' => $_POST['bank_name'],
        'check_amount' => (float)str_replace(',', '', $_POST['check_amount']),
        'bank_deposited_id' => $_POST['bank_deposited'],
        'check_status' => $_POST['check_status'],
        'received_date' => $_POST['received_date'] ? date('Y-m-d', strtotime($_POST['received_date'])) : null,
        'pustak_kramanak' => $_POST['pustak_kramanak'],
        'pavati_kramanak' => $_POST['pavati_kramanak'],
        'reason' => $_POST['reason'] ?? null,
        'created_by' => $_SESSION['user_id'] ?? null,
        'panchayat_code' => $_SESSION['panchayat_code']
    ];
    $result = $fun->insertRecord( 'check_status', $data);
    
    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Check status saved successfully';
        $response['id'] = $result;
    } else {
        throw new Exception('Failed to save check status');
    }
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);