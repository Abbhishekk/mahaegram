<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

try {
    
    if (!isset($_SESSION['district_code'])) {
        throw new Exception('District code not found in session');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'material_name' => $_POST['material_name'] ?? '',
            'district_code' => $_SESSION['district_code']
        ];
        
        // Validate
        if (empty($data['material_name'])) {
            throw new Exception('Material name is required');
        }
        
        if (!empty($_POST['material_id'])) {
            // Update
            $id = (int)$_POST['material_id'];
            $success = $fun->updateMaterial($id, $data);
            $message = $success ? 'Material updated successfully' : 'Failed to update material';
        } else {
            // Add
            $success = $fun->addMaterial($data);
            $message = $success ? 'Material added successfully' : 'Failed to add material';
        }
        
        if ($success) {
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = 'success';
        } else {
            throw new Exception($message);
        }
        
        header('Location: ../namuna10_master_vastu.php');
        exit;
    }
    
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $success = $fun->deleteMaterial($id, $_SESSION['district_code']);
        
        if ($success) {
            $_SESSION['message'] = 'Material deleted successfully';
            $_SESSION['message_type'] = 'success';
        } else {
            throw new Exception('Failed to delete material');
        }
        
        header('Location: ../namuna10_master_vastu.php');
        exit;
    }
    
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: ../namuna10_master_vastu.php');
    exit;
}