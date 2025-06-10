<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false];

if (isset($_POST['material_id'])) {
    $materialId = $_POST['material_id'];
    $namunaNumber = $_POST['namuna_number'] ?? '';
    $conn = new Connect();
    $conn = $conn->dbConnect();
    $fun = new Fun($conn);

    // Get the material details
    $material = $conn->query("SELECT * FROM pavati_pustak WHERE id = $materialId AND panchayat_code = '$_SESSION[panchayat_code]'")->fetch_assoc();
    // print_r($material);
    if (empty($material)) {
        echo json_encode(['success' => false, 'message' => 'Material not found']);
        exit;
    }

    $materialId = $material["id"];
    // print_r($materialId);
    $totalBooks = $material["total_number"];

    // Get the last distributed book number for this material and namuna
    $lastBook = $conn->query(
        "SELECT MAX(book_number) as last_book FROM pavati_pustak_vitaran 
         WHERE material_id = '$materialId' AND namuna_number = '$namunaNumber' AND panchayat_code = '$_SESSION[panchayat_code]';"
    )->fetch_assoc();
    // print_r($lastBook);
    $nextBookNumber = 1;
    if (!empty($lastBook) && isset($lastBook['last_book'])) {
        $nextBookNumber = (int) $lastBook['last_book'] + 1;
    }
    // Check if we've exceeded total books
    if ($nextBookNumber > $totalBooks) {
        $response['success'] = false;
        $response['message'] = 'या साहित्यासाठीची सर्व पुस्तके आधीच वितरित केली गेली आहेत.';
        // $_SESSION['message'] = 'या साहित्यासाठीची सर्व पुस्तके आधीच वितरित केली गेली आहेत.';
        // $_SESSION['message_type'] = 'danger';
        // echo json_encode([
        //     'success' => false,
        //     'message' => 'All books distributed. Please add more books for this material.'
        // ]);
        // exit;
    } else {
        $bookNumber = $material['material_number'] . '/' . $namunaNumber . '/' . $nextBookNumber;
        $response['success'] = true;
        $response['book_number'] = $bookNumber;
        $response['next_book'] = $nextBookNumber;
        $response['total_books'] = $totalBooks;
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }

    // Format the book number as "material_number/namuna_number/book_number"
    // echo json_encode([
    //     'success' => true,
    //     'book_number' => $bookNumber,
    //     'next_book' => $nextBookNumber,
    //     'total_books' => $totalBooks
    // ]);

}

header('Content-Type: application/json');
echo json_encode($response);
