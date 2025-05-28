<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false, 'books' => []];

try {
      $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);
    
    // Get all unique book numbers (x/y format) from your database
    // This query depends on your actual table structure
    $query = "SELECT DISTINCT book_number FROM pavati_pustak_vitaran where `panchayat_code` = '$_SESSION[panchayat_code]'; ";
    $result = $conn->query($query);
    
    $books = [];
    
    while ($row = $result->fetch_assoc()) {
        // Split the x/y format
        $parts = explode('/', $row['book_number']);
        $x = $parts[0];
        $y = $parts[1];
        
        // Group by x and track the maximum y for each x
        if (!isset($books[$x])) {
            $books[$x] = ['x' => $x, 'max_y' => $y];
        } else {
            if ($y > $books[$x]['max_y']) {
                $books[$x]['max_y'] = $y;
            }
        }
    }
    
    // Convert to simple array
    $response['books'] = array_values($books);
    $response['success'] = true;
    
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>