<?php
// api/get_malmatta_details.php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

header('Content-Type: application/json');

$response = ['success' => false, 'data' => null];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $ward = $_POST['ward'] ?? '';
    $malmatta_id = $_POST['malmatta_id'] ?? '';

    if (empty($ward)) throw new Exception('Ward is required');
    if (empty($malmatta_id)) throw new Exception('Malmatta ID is required');

      $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);
    
    
    $result = $fun->getPropertyVerificationsWithWardAndId($ward, $malmatta_id);
    $malmattaDataEntry = $fun->getMalmattaDataEntryById($malmatta_id, $_SESSION['district_code']);
    if ($result->num_rows === 0) {
        throw new Exception('No property found with these details');
    }

    $response['success'] = true;
    $response['data'] = $result->fetch_assoc();
    $response['malmatta_no'] = $malmattaDataEntry->fetch_assoc();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);