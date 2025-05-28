<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false];

if (isset($_POST['material_id'])) {
    $materialId = $_POST['material_id'];
      $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);
    
    // Get last book number for this material
    $lastBook = $fun->getLastPavatiPustakVitaran();
   
    
    if ($lastBook) {
        // Parse the last book number (format x/y)
        $parts = explode('/', $lastBook['book_number']);
        $x = (int)$parts[0];
        $y = (int)$parts[1];
            // echo "Parsed Book Number: x = $x, y = $y\n";
        if ($y < 100) {
            $y++;
        } else {
            $x++;
            $y = 1;
        }
    } else {
        // First book for this material
        $x = 1;
        $y = 1;
    }
    
    $response = [
        'success' => true,
        'book_number' => $x . '/' . $y
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>