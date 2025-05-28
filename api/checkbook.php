<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

// Add this to your existing checkbook.php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getBanksByPlan'])) {
    $plan_name = $fun->sanitize($_GET['plan_name']);
    // echo $plan_name;
    $banks = $fun->getBankByPlanName($plan_name);

    echo json_encode($banks);
    exit;
}

try {
 
    
    // Check if district code exists in session
    if (!isset($_SESSION['district_code'])) {
        throw new Exception('District code not found in session');
    }
    
    // Handle POST request (add/update)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'plan_name' => $_POST['plan_name'] ?? '',
            'bank_name' => $_POST['bank_name'] ?? '',
            'checkbook_no' => $_POST['checkbook_no'] ?? '',
            'first_check_no' => $_POST['first_check_no'] ?? '',
            'check_no' => $_POST['check_no'] ?? '',
            'last_check_no' => $_POST['last_check_no'] ?? '',
            'date' => $_POST['date'] ?? '',
            'district_code' => $_SESSION['district_code']
        ];
        
        // Validate data
        $errors = [];
        if (empty($data['plan_name'])) $errors[] = 'Plan name is required';
        if (empty($data['bank_name'])) $errors[] = 'Bank is required';
        if (empty($data['checkbook_no'])) $errors[] = 'Checkbook number is required';
        if (empty($data['first_check_no'])) $errors[] = 'First check number is required';
        if (empty($data['check_no'])) $errors[] = 'Number of checks is required';
        if (empty($data['last_check_no'])) $errors[] = 'Last check number is required';
        if (empty($data['date'])) $errors[] = 'Date is required';
        
        if (!empty($errors)) {
            throw new Exception(implode('<br>', $errors));
        }
        
        // Check if this is an update or add operation
        if (!empty($_POST['checkbook_id'])) {
            // Update operation
            $id = (int)$_POST['checkbook_id'];
            $success = $fun->updateCheckbook($id, $data);
            $message = $success ? 'Checkbook updated successfully' : 'Failed to update checkbook';
        } else {
            // Add operation
            $success = $fun->addCheckbook($data);
            $message = $success ? 'Checkbook added successfully' : 'Failed to add checkbook';
        }
        
        if ($success) {
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = 'success';
        } else {
            throw new Exception($message);
        }
        
        header('Location: ../namuna10_master_chekbuk.php');
        exit;
    }
    
    // Handle DELETE request
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $success = $fun->deleteCheckbook($id, $_SESSION['district_code']);
        
        if ($success) {
            $_SESSION['message'] = 'Checkbook deleted successfully';
            $_SESSION['message_type'] = 'success';
        } else {
            throw new Exception('Failed to delete checkbook');
        }
        
        header('Location: ../namuna10_master_chekbuk.php');
        exit;
    }
    
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: ../namuna10_master_chekbuk.php');
    exit;
}