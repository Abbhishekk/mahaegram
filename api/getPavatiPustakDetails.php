<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
       $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);
    
    $material = $fun->getPavatiPustakById($id, $_SESSION['district_code']);
    
    if ($material) {
        $response = [
            'success' => true,
            'material_number' => $material['material_number'],
            'total_number' => $material['total_number']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>