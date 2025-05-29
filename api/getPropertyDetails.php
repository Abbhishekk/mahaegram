<?php
// Include necessary files
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

// Set content type header
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'data' => [],
    'message' => '',
    'is_property_approved' => false
];

try {
    // Create database connection
    $conn = new Connect();
    $conn = $conn->dbConnect();

    // Check if malmatta_id is provided
    if (!isset($_POST['malmatta_id']) || empty($_POST['malmatta_id'])) {
        $response['message'] = 'Malmmatta ID is required';
        echo json_encode($response);
        exit;
    }

    $malmattaId = $_POST['malmatta_id'];
        // print_r($malmattaId);
    // Query to get property details from property_verifications (approved properties)
    $query = "SELECT * FROM `tax_demands` WHERE `malmatta_id` = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $stmt->bind_param("s", $malmattaId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Query to get property details from malmatta_data_entry (unapproved properties)
    $property_info_query = "SELECT ward_no, owner_name FROM malmatta_data_entry WHERE id = ?";
    $property_stmt = $conn->prepare($property_info_query);
    
    if (!$property_stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $property_stmt->bind_param("s", $malmattaId);
    $property_stmt->execute();
    $property_result = $property_stmt->get_result();
    // print_r($property_result);
    // print_r($result);
    // Check if property is approved (exists in property_verifications)
    // if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // $property_row = $property_result->fetch_assoc();
        // echo "Property found in property_verifications:\n";
        // print_r($row);
        $response['success'] = true;
        $response['data'] = [
            'ward_no' => $row['ward'],
            'owner_name' => $row['owner_name'],
            'malmatta_info' => $row ?: null
        ];
        $response['is_property_approved'] = true;
    // } 
    // Check if property exists in malmatta_data_entry (unapproved)
    // elseif ($property_result->num_rows > 0) {
    //     $property_row = $property_result->fetch_assoc();
    //     // echo "Property found in malmatta_data_entry:\n";
    //     // print_r($property_row);
        
    //     $response['success'] = true;
    //     $response['data'] = [
    //         'ward_no' => $property_row['ward_no'],
    //         'owner_name' => $property_row['owner_name'],
    //         'malmatta_info' => $property_row
    //     ];
    //     $response['is_property_approved'] = false;
    // } else {
    //     $response['message'] = 'No property found with the given ID';
    // }

    // Close statements
    $stmt->close();
    $property_stmt->close();
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    // Close connection if it exists
    if (isset($conn)) {
        $conn->close();
    }
    
    // Send JSON response
    echo json_encode($response);
}
?>