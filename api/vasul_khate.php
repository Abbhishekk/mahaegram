<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($conn);

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
    $district_code = $_SESSION['district_code'];

    

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
    global $conn, $fun, $district_code, $response;

    // Validate required fields
    $required = ['tax_type', 'account_name'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Required field '$field' is missing");
        }
    }

    // Prepare data
    $balance_id = !empty($_POST['balance_id']) ? (int)$_POST['balance_id'] : null;
    $tax_type = $fun->sanitize($_POST['tax_type']);
    $account_name = $fun->sanitize($_POST['account_name']);

    // Check if record already exists for this combination
    $checkQuery = "SELECT id FROM vasul_khate 
                  WHERE district_code = ? AND tax_type = ? AND account_name = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("sss", $district_code, $tax_type, $account_name);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0 && (!$balance_id || $checkResult->fetch_assoc()['id'] != $balance_id)) {
        throw new Exception("A record already exists for this tax type and account combination");
    }

    if ($balance_id) {
        // Update existing record
        $query = "UPDATE vasul_khate SET 
                 tax_type = ?, account_name = ?
                 WHERE id = ? AND district_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", 
            $tax_type, $account_name, $balance_id, $district_code
        );
    } else {
        // Insert new record
        $query = "INSERT INTO vasul_khate 
                 (district_code, tax_type, account_name)
                 VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", 
            $district_code, $tax_type, $account_name
        );
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $balance_id ? "Record updated successfully" : "Record added successfully";
        
        if (!$balance_id) {
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
    global $conn, $district_code, $response;

    $balance_id = (int)$_GET['delete'];
    
    $query = "DELETE FROM vasul_khate WHERE id = ? AND district_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $balance_id, $district_code);
    
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
    header('Location: ../namuna10_varshikkamkaj_vasuli_khate.php');
    exit;
}