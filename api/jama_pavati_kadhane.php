<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $book_number = isset($_POST['book_number']) ? trim($_POST['book_number']) : '';
    $receipt_number = isset($_POST['receipt_number']) ? trim($_POST['receipt_number']) : '';
    $collection_date = isset($_POST['collection_date']) ? trim($_POST['collection_date']) : '';
    $owner_name = isset($_POST['owner_name']) ? trim($_POST['owner_name']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $property_number = isset($_POST['property_number']) ? trim($_POST['property_number']) : '';
    $bank_name = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
    $check_number = isset($_POST['check_number']) ? trim($_POST['check_number']) : '';
    $check_date = isset($_POST['check_date']) ? trim($_POST['check_date']) : '';

    // Validate required fields
    $errors = [];
    
    if (empty($book_number)) {
        $errors[] = "बुक नंबर आवश्यक आहे";
    }
    
    if (empty($receipt_number)) {
        $errors[] = "पावती नंबर आवश्यक आहे";
    }
    
    if (empty($collection_date)) {
        $errors[] = "वसुल दिनांक आवश्यक आहे";
    } elseif (!validateDate($collection_date)) {
        $errors[] = "अवैध वसुल दिनांक";
    }
    
    if (empty($bank_name)) {
        $errors[] = "बँकेचे नाव आवश्यक आहे";
    }
    
    if (empty($check_date)) {
        $errors[] = "चेक दिनांक आवश्यक आहे";
    } elseif (!validateDate($check_date)) {
        $errors[] = "अवैध चेक दिनांक";
    }
    
    // Amount validation
    if (!empty($amount) && !is_numeric($amount)) {
        $errors[] = "वसूल रक्कम फक्त संख्या असावी";
    }
    
    // If there are errors, show them
    if (!empty($errors)) {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "danger";
        header("Location: ../namuna10_dainandinkamkaj_jamapavtikadhne.php");
        exit();
    }
    
    // Prepare data for insertion
    $data = [
        'book_number' => $book_number,
        'receipt_number' => $receipt_number,
        'collection_date' => $collection_date,
        'owner_name' => $owner_name,
        'collected_amount' => $amount,
        'property_number' => $property_number,
        'bank_name' => $bank_name,
        'cheque_number' => $check_number,
        'cheque_date' => $check_date,
        'panchayat_code' => $_SESSION['panchayat_code'],
        'created_by' => $_SESSION['user_id']
    ];
    
    // Insert into database
    try {
        $success = $fun->insertJamaPavatiKadhane($data);
        
        if ($success) {
            $_SESSION['message'] = "पावती यशस्वीरित्या निर्माण केली";
            $_SESSION['message_type'] = "success";
            
            // Generate PDF receipt
            generateReceiptPDF($data);
        } else {
            $_SESSION['message'] = "पावती निर्माण करताना त्रुटी";
            $_SESSION['message_type'] = "danger";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "त्रुटी: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: ../namuna10_dainandinkamkaj_jamapavtikadhne.php");
    exit();
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function generateReceiptPDF($data) {
    // Implement PDF generation logic here using TCPDF or similar library
    // This function should create and save/download the receipt PDF
    // Example:
    /*
    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('freeserif', '', 12);
    
    // Add receipt content
    $html = '<h1>पावती क्रमांक: '.$data['receipt_number'].'</h1>';
    $html .= '<p>नाव: '.$data['owner_name'].'</p>';
    $html .= '<p>रक्कम: '.$data['collected_amount'].'</p>';
    // Add more receipt details
    
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Output PDF
    $pdf->Output('receipt_'.$data['receipt_number'].'.pdf', 'D');
    */
}