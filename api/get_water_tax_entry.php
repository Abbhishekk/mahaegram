<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($conn);

header('Content-Type: application/json');

$malmatta_no = $_POST['malmatta_no'] ?? null;
$year = $_POST['year'] ?? null;

if (!$malmatta_no || !$year) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$query = "SELECT * FROM water_tax WHERE malmatta_no = ? AND year = ? and panchayat_code = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $malmatta_no, $year, $_SESSION['panchayat_code']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
} else {
    echo json_encode(['success' => false, 'message' => 'No entry found']);
}
?>
