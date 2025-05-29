<?php
// api/save_tax_demand.php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($conn);

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input');
    }

    // Validate required fields
    $requiredFields = [
        'ward', 'malmatta_id', 'owner_name', 'financial_year',
        'building_tax', 'light_tax', 'health_tax', 'water_tax',
        'padsar_tax', 'total_amount'
    ];
    
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Required field '$field' is missing");
        }
    }

    
    // Prepare data for insertion
    $data = [
        'ward' => $input['ward'],
        'malmatta_id' => $input['malmatta_id'],
        'owner_name' => $input['owner_name'],
        'financial_year' => $input['financial_year'],
        'building_tax' => (float)$input['building_tax'],
        'light_tax' => (float)$input['light_tax'],
        'health_tax' => (float)$input['health_tax'],
        'water_tax' => (float)$input['water_tax'],
        'padsar_tax' => (float)$input['padsar_tax'],
        'fine' => (float)($input['fine'] ?? 0),
        'notice_fee' => (float)($input['notice_fee'] ?? 0),
        'discount' => (float)($input['discount'] ?? 0),
        'total_amount' => (float)$input['total_amount'],
        'created_by' => $input['created_by'] ?? null,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Insert into database
    $result = $fun->insertRecord( 'tax_demands', $data);
    
    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Tax demand saved successfully';
        $response['id'] = $result;
    } else {
        throw new Exception('Failed to save tax demand');
    }
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);