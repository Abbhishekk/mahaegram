<?php
session_start(); // Start session to store messages

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
    if(!isset($_SESSION['panchayat_code'])) {
        throw new Exception("Panchayat code not found in session");
    }
    $district_code = $_SESSION['district_code'];
    $panchayat_code = $_SESSION['panchayat_code'];

    // Handle different operations
    $operation = $_SERVER['REQUEST_METHOD'];
    
    if ($operation == 'POST') {
        handlePostRequest();
    } elseif ($operation == 'GET') {
        if (isset($_GET['delete'])) {
            handleDeleteRequest();
        } elseif (isset($_GET['getBanksByPlan'])) {
            handleGetBanksByPlan();
        } elseif (isset($_GET['getAccountBalance'])) {
            handleGetAccountBalance();
        }
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
    $required = ['plan_name', 'date', 'bank_name', 'check_book_no', 
                'check_no', 'amount_to_pay', 'bank_name_to_deposit', 'payer_name'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Required field '$field' is missing");
        }
    }

    // Prepare data
    $transfer_id = !empty($_POST['bank_bharane_id']) ? (int)$_POST['bank_bharane_id'] : null;
    $plan_name = $fun->sanitize($_POST['plan_name']);
    $financial_year = $fun->sanitize($_POST['financial_year']);
    $date = $fun->sanitize($_POST['date']);
    $from_bank_id = (int)$_POST['bank_name'];
    $check_book_no = $fun->sanitize($_POST['check_book_no']);
    $check_no = $fun->sanitize($_POST['check_no']);
    $amount = (float)$_POST['amount_to_pay'];
    $to_bank_id = (int)$_POST['bank_name_to_deposit'];
    $payer_name = $fun->sanitize($_POST['payer_name']);

    if ($transfer_id) {
        // Update existing record
        $query = "UPDATE bank_to_bank_transfers SET 
                 plan_name = ?, financial_year = ?, date = ?, 
                 from_bank_id = ?, check_book_no = ?, check_no = ?,
                 amount = ?, to_bank_id = ?, payer_name = ?
                 WHERE id = ? AND district_code = ? and panchayat_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssddisis", 
            $plan_name, $financial_year, $date,
            $from_bank_id, $check_book_no, $check_no,
            $amount, $to_bank_id, $payer_name,
            $transfer_id, $district_code, $panchayat_code
        );
    } else {
        // Insert new record
        $query = "INSERT INTO bank_to_bank_transfers 
                 (district_code, plan_name, financial_year, date, 
                 from_bank_id, check_book_no, check_no,
                 amount, to_bank_id, payer_name, panchayat_code)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssissdiss", 
            $district_code, $plan_name, $financial_year, $date,
            $from_bank_id, $check_book_no, $check_no,
            $amount, $to_bank_id, $payer_name, $panchayat_code
        );
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $transfer_id ? "Transfer updated successfully" : "Transfer added successfully";
        
        if (!$transfer_id) {
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

    $transfer_id = (int)$_GET['delete'];
    
    $query = "DELETE FROM bank_to_bank_transfers WHERE id = ? AND district_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $transfer_id, $district_code);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Transfer record deleted successfully";
    } else {
        throw new Exception("Failed to delete transfer record: " . $stmt->error);
    }
}

/**
 * Handle GET banks by plan request
 */
function handleGetBanksByPlan() {
    global $conn, $fun, $district_code, $response, $panchayat_code;

    if (empty($_GET['plan_name'])) {
        throw new Exception("Plan name is required");
    }

    $plan_name = $fun->sanitize($_GET['plan_name']);
    
    $query = "SELECT b.id, b.bank_name FROM bank_master b
              WHERE b.plan_name = ? AND b.district_code = ? and b.panchayat_code = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $plan_name, $district_code, $panchayat_code);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $banks = [];
    while ($row = $result->fetch_assoc()) {
        $banks[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $banks
    ]);
    exit;
}

function handleGetAccountBalance() {
    global $conn, $fun, $district_code, $response, $panchayat_code;

    

    $bank_id = (int)$_GET['selectedBank'];
    $plan_name = $fun->sanitize($_GET['plan_name']);
    $balance_types = ["हात शिल्लक", "बँक शिल्लक", "पोस्ट शिल्लक", "ठेवी"];
    $balances = [];

    // Prepare query to fetch all balance types at once
    $query = "SELECT balance_type, amount FROM year_start_balances 
              WHERE bank_id = ? AND plan_name = ? AND district_code = ? AND panchayat_code = ?
              AND balance_type IN (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssss", 
        $bank_id, 
        $plan_name, 
        $district_code, 
        $panchayat_code,
        $balance_types[0],
        $balance_types[1],
        $balance_types[2],
        $balance_types[3]
    );
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize all balance types with 0
    foreach ($balance_types as $type) {
        $balances[$type] = 0;
    }

    // Populate with actual values from database
    while ($row = $result->fetch_assoc()) {
        $balances[$row['balance_type']] = (float)$row['amount'];
    }

    // Return all balances
    echo json_encode([
        'success' => true,
        'data' => [
            'balances' => $balances,
            'hand_balance' => $balances["हात शिल्लक"],
            'bank_balance' => $balances["बँक शिल्लक"],
            'post_balance' => $balances["पोस्ट शिल्लक"],
            'deposit_balance' => $balances["ठेवी"]
        ]
    ]);
    exit;
}

// Close connection
$conn->close();

// Set session message and redirect if not API call
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo json_encode($response);
} else {
    $_SESSION['message'] = $response['message'];
    $_SESSION['message_type'] = $response['success'] ? 'success' : 'danger';
    header('Location: ../namuna10_dainandin_khate_to_khate_transfar.php');
    exit;
}