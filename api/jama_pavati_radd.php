<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    // Validate required fields
    $requiredFields = [
        'book_no' => 'बुक नंबर',
        'receipt_no' => 'पावती नंबर',
        'reason' => 'पावती रद्द कारण'
    ];

    $missingFields = [];
    foreach ($requiredFields as $field => $fieldName) {
        if (empty($_POST[$field])) {
            $missingFields[] = $fieldName;
        }
    }

    if (!empty($missingFields)) {
        throw new Exception("कृपया सर्व आवश्यक फील्ड भरा: " . implode(', ', $missingFields));
    }

    // Sanitize inputs
    $book_no = trim($_POST['book_no']);
    $receipt_no = trim($_POST['receipt_no']);
    $reason = trim($_POST['reason']);
    $user_id = $_SESSION['user_id'] ?? null;

    // Validate receipt exists and is not already cancelled
    $receiptExists = $fun->checkReceiptExists($book_no, $receipt_no);
    if (!$receiptExists) {
        throw new Exception("ही पावती अस्तित्वात नाही");
    }

    $isCancelled = $fun->isReceiptCancelled($book_no, $receipt_no);
    if ($isCancelled) {
        throw new Exception("ही पावती आधीच रद्द केली गेली आहे");
    }

    // Begin transaction
    $connect->dbConnect()->begin_transaction();

    try {
        // 1. Cancel the receipt
        $cancelled = $fun->cancelReceipt($book_no, $receipt_no, $reason, $user_id);
        if (!$cancelled) {
            throw new Exception("पावती रद्द करण्यात अयशस्वी");
        }

        // 2. Log the cancellation (optional)
        $logged = $fun->logReceiptCancellation($book_no, $receipt_no, $reason, $user_id);
        
        // Commit transaction
        $connect->dbConnect()->commit();

        $response = [
            'success' => true,
            'message' => 'पावती यशस्वीरित्या रद्द केली गेली',
            'redirect' => 'receipt_cancellation.php'
        ];

        $_SESSION['message'] = $response['message'];
        $_SESSION['message_type'] = 'success';

    } catch (Exception $e) {
        $connect->dbConnect()->rollback();
        throw $e;
    }

} catch (mysqli_sql_exception $e) {
    $response['message'] = "डेटाबेस त्रुटी: " . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit();