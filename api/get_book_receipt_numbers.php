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
    $query = "SELECT DISTINCT book_number, pavati_number FROM pavati_pustak_vitaran where `panchayat_code` = '$_SESSION[panchayat_code]' and namuna_number= 10; ";
    $result = $conn->query($query);

    $books = [];
    $pavatiNumber = [];
    while ($row = $result->fetch_assoc()) {
        // Split the x/y format
        $books[] = $row["book_number"];
        $pavatiNumber[] = $row["pavati_number"];
    }

    // Convert to simple array
    $response['books'] = array_values($books);
    $response['pavatiNumber'] = array_values($pavatiNumber);
    $response['success'] = true;

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>