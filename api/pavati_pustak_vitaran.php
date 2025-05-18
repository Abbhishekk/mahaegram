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
    if (!isset($_SESSION['panchayat_code'])) {
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
    $required = ['plan_name', 'material_number_pavati', 'namuna_number', 'pavati_number', 
                'given_person_name', 'book_number', 'pavati_pasun', 'pavati_paryant', 'financial_year'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Required field '$field' is missing");
        }
    }

    // Prepare data
    $distribution_id = !empty($_POST['distribution_id']) ? (int)$_POST['distribution_id'] : null;
    $plan_name = $fun->sanitize($_POST['plan_name']);
    $financial_year = $fun->sanitize($_POST['financial_year']);
    $material_id = (int)$_POST['material_number_pavati'];
    $namuna_number = $fun->sanitize($_POST['namuna_number']);
    $pavati_number = $fun->sanitize($_POST['pavati_number']);
    $given_person_name = $fun->sanitize($_POST['given_person_name']);
    $book_number = $fun->sanitize($_POST['book_number']);
    $pavati_pasun = $fun->sanitize($_POST['pavati_pasun']);
    $pavati_paryant = $fun->sanitize($_POST['pavati_paryant']);

    if ($distribution_id) {
        // Update existing record
        $query = "UPDATE pavati_pustak_vitaran SET 
                 plan_name = ?, financial_year = ?, material_id = ?, 
                 namuna_number = ?, pavati_number = ?, given_person_name = ?,
                 book_number = ?, pavati_pasun = ?, pavati_paryant = ?
                 WHERE id = ? AND district_code = ? and panchayat_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssissssssiss", 
            $plan_name, $financial_year, $material_id,
            $namuna_number, $pavati_number, $given_person_name,
            $book_number, $pavati_pasun, $pavati_paryant,
            $distribution_id, $district_code, $panchayat_code
        );
    } else {
        // Insert new record
        $query = "INSERT INTO pavati_pustak_vitaran 
                 (district_code, plan_name, financial_year, material_id, 
                 namuna_number, pavati_number, given_person_name,
                 book_number, pavati_pasun, pavati_paryant, panchayat_code)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssisssssss", 
            $district_code, $plan_name, $financial_year, $material_id,
            $namuna_number, $pavati_number, $given_person_name,
            $book_number, $pavati_pasun, $pavati_paryant, $panchayat_code
        );
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $distribution_id ? "Distribution record updated successfully" : "Distribution record added successfully";
        
        if (!$distribution_id) {
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

    $distribution_id = (int)$_GET['delete'];
    
    $query = "DELETE FROM pavati_pustak_vitaran WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $distribution_id);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Distribution record deleted successfully";
    } else {
        throw new Exception("Failed to delete distribution record: " . $stmt->error);
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