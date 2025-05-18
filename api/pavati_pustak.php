<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'data' => []
];

try {
    

    // Check if district code is set in session
    if (!isset($_SESSION['district_code'])) {
        throw new Exception("District code not found in session");
    }
    if(!isset($_SESSION['panchayat_code'])){
        throw new Exception("Panchayat code not found in session");
    }
    $district_code = $_SESSION['district_code'];
    $panchayat_code = $_SESSION['panchayat_code'];

    
    // Handle different operations
    $operation = $_SERVER['REQUEST_METHOD'];
    
    if ($operation == 'POST') {
        handlePostRequest();
    } elseif ($operation == 'GET' && isset($_GET['delete'])) {
        handleDeleteRequest();
    } else {
        throw new Exception("Invalid request method");
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    echo json_encode($response);
    exit;
}

/**
 * Handle POST requests (create/update)
 */
function handlePostRequest() {
    global $conn, $fun, $district_code, $response, $panchayat_code;

    // Validate required fields
    $required = ['buying_date', 'material_type', 'material_number', 'total_number', 'financial_year'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Required field '$field' is missing");
        }
    }

    // Prepare data
    $record_id = !empty($_POST['balance_id']) ? (int)$_POST['balance_id'] : null;
    $buying_date = $fun->sanitize($_POST['buying_date']);
    $financial_year = $fun->sanitize($_POST['financial_year']); // You'll need to implement this function
    $material_type = $fun->sanitize($_POST['material_type']);
    $material_number = $fun->sanitize($_POST['material_number']);
    $total_number = (int)$_POST['total_number'];

    if ($record_id) {
        // Update existing record
        $query = "UPDATE pavati_pustak SET 
                 buying_date = ?, financial_year = ?, material_type = ?, 
                 material_number = ?, total_number = ?
                 WHERE id = ? AND district_code = ? AND panchayat_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssiiss", 
            $buying_date, $financial_year, $material_type,
            $material_number, $total_number, $record_id, $district_code, $panchayat_code
        );
    } else {
        // Insert new record
        $query = "INSERT INTO pavati_pustak 
                 (district_code, buying_date, financial_year, material_type, material_number, total_number, panchayat_code)
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssis", 
            $district_code, $buying_date, $financial_year, 
            $material_type, $material_number, $total_number, $panchayat_code
        );
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $record_id ? "Record updated successfully" : "Record added successfully";
        
        if (!$record_id) {
            $response['data']['id'] = $conn->insert_id;
        }
    } else {
        throw new Exception("Database error: " . $stmt->error);
    }
}

/**
 * Handle DELETE requests
 */
function handleDeleteRequest() {
    global $conn, $district_code, $response, $panchayat_code;

    $record_id = (int)$_GET['delete'];
    
    $query = "DELETE FROM pavati_pustak WHERE id = ? AND district_code = ? and panchayat_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $record_id, $district_code, $panchayat_code);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Record deleted successfully";
    } else {
        throw new Exception("Failed to delete record: " . $stmt->error);
    }
}

// Close connection
$conn->close();

// Set session message and redirect if not API call
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo json_encode($response);
} else {
    $_SESSION['message'] = $response['message'];
    $_SESSION['message_type'] = $response['success'] ? 'success' : 'danger';
    header('Location: ../namuna10_varshikkamkaj_pavati_pustak_nond.php');
    exit;
}