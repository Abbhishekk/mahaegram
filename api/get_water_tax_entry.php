<?php
session_start();
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

header('Content-Type: application/json');

$malmatta_no = (int) ($_POST['malmatta_no'] ?? 0);
$year = $_POST['year'] ?? null;
$panchayat_code = $_SESSION['panchayat_code'] ?? null;

if (!$malmatta_no || !$year || !$panchayat_code) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$query = "SELECT * FROM water_tax WHERE malmatta_no = ? AND year = ? AND panchayat_code = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("iss", $malmatta_no, $year, $panchayat_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
} else {
    echo json_encode(['success' => false, 'message' => 'No entry found']);
}
?>
