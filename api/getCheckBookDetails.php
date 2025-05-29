<?php
// api/get_checkbook_details.php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

header('Content-Type: application/json');

$response = ['success' => false, 'data' => null];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $checkbook_id = $_POST['checkbook_id'] ?? '';
    if (empty($checkbook_id)) throw new Exception('Checkbook ID is required');

      $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);
    
    // Query to get checkbook details
    $query = "SELECT * FROM checkbooks
                left join bank_master on checkbooks.bank_id = bank_master.id
                 WHERE checkbooks.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $checkbook_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('No checkbook found with this ID');
    }

    $response['success'] = true;
    $response['data'] = $result->fetch_assoc();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);