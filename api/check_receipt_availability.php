<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false, 'message' => ''];
$conn = new Connect();
$conn = $conn->dbConnect();
$fun = new Fun($conn);
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pustak_kramanak = $_POST['pustak_kramanak'] ?? '';
        $pavati_kramanak = $_POST['pavati_kramanak'] ?? '';

        if (empty($pustak_kramanak)) {
            throw new Exception("पुस्तक क्रमांक आवश्यक आहे");
        }

        if (empty($pavati_kramanak)) {
            throw new Exception("पावती क्रमांक आवश्यक आहे");
        }

        // Check if receipt number is already used
        $stmt = $conn->prepare("SELECT COUNT(*) FROM karvasuli_records 
                              WHERE pustak_kramanak = ? AND pavati_kramanak = ?");
        $stmt->execute([$pustak_kramanak, $pavati_kramanak]);
        $count = $stmt->num_rows();

        $response['success'] = true;
        $response['available'] = ($count == 0);
        $response['message'] = $count == 0 ? 'पावती क्रमांक उपलब्ध आहे' : 'पावती क्रमांक आधीच वापरला गेला आहे';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>