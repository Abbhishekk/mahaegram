<?php
header('Content-Type: application/json');

include "../include/connect/db.php";
include "../include/connect/fun.php";

$conn = new Connect();
$conn = $conn->dbConnect();
$taxType = $_GET['tax_type'] ?? '';

if ($taxType === '') {
    echo json_encode(['error' => 'Missing tax_type parameter']);
    exit;
}


$stmt = $conn->prepare("SELECT * FROM readyrec_info WHERE id = ?");
$stmt->bind_param('s', $taxType);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['readyrec_type' => $row['readyrec_type'], "yearly_tax" => $row['yearly_tax'], "id"=> $row['id']]);
} else {
    echo json_encode(['readyrec_type' => null,'yearly_tax' => null, "id"=> null]);
}

$stmt->close();
$conn->close();
?>