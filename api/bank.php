<?php
// api/bank.php
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


// Handle POST request (add new bank)
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure table exists
  
    
    // Check if this is an update or add operation
    if (!empty($_POST['bank_id'])) {
        // This is an update operation
        $id = (int)$_POST['bank_id'];
        $result = $fun->updateBank($id, $_POST);
    } else {
        // This is an add operation
        $result = $fun->addBank( $_POST);
    }
    
    if ($result['success']) {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'danger';
    }
    
    header('Location: ../namuna10_master_bank.php');
    exit;
}

// Handle update
if (isset($_GET['update'])) {
    $id = (int)$_GET['update'];
    $result = $fun->updateBank( $id, $_POST);
    
    if ($result['success']) {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'danger';
    }
    
    header('Location: ../namuna10_master_bank.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $result = $fun->deleteBank( $id);
    
    if ($result['success']) {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'danger';
    }
    
    header('Location: ../namuna10_master_bank.php');
    exit;
}
// Handle GET request (get banks)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $fun->getBanks();
    
    if ($result['success']) {
        $response['success'] = true;
        $response['data'] = $result['data'];
    } else {
        $response['message'] = $result['message'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


$conn->close();
?>