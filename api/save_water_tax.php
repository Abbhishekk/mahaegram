<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($conn);

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

$malmatta_no = $_POST['malmatta_no'];
$year = $_POST['financial_year'];
$pani_prakar = $_POST['pani_prakar'];
$total_amount = $_POST['total_amount'];
$khasara_no = $_POST['khasara_no'] ?? '';
$ittar_akar = $_POST['ittar_aakar'] ?? '';

$columns = ['april','may','jun','jul','aug','sep','oct','nov','dec','jan','feb','mar'];
$readings = [];

foreach ($columns as $col) {
  $readings[$col] = $_POST["{$col}_reading"] ?? '0';
}

$malmatta_no = $_POST['malmatta_no'];
$year = $_POST['financial_year'];

$query = "SELECT id FROM water_tax WHERE malmatta_no = ? AND year = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $malmatta_no, $year);
$stmt->execute();
$result = $stmt->get_result();

$isUpdate = false;
$existingId = null;

if ($result->num_rows > 0) {
    $isUpdate = true;
    $existingId = $result->fetch_assoc()['id'];
}

if ($isUpdate) {
    $sql = "UPDATE water_tax SET 
        jan_reading=?, feb_reading=?, mar_reading=?, april_reading=?, may_reading=?, 
        jun_reading=?, jul_reading=?, aug_reading=?, sep_reading=?, oct_reading=?, 
        nov_reading=?, dec_reading=?, pani_prakar=?, total_amount=?, khasara_no=?, ittar_aakar=?,
        updated_at=NOW()
        WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssiissi", 
        $_POST['jan_reading'], $_POST['feb_reading'], $_POST['mar_reading'],
        $_POST['april_reading'], $_POST['may_reading'], $_POST['jun_reading'],
        $_POST['jul_reading'], $_POST['aug_reading'], $_POST['sep_reading'],
        $_POST['oct_reading'], $_POST['nov_reading'], $_POST['dec_reading'],
        $_POST['pani_prakar'], $_POST['total_amount'], $_POST['khasara_no'], $_POST['ittar_aakar'], $existingId
    );
    $stmt->execute();
    if ($stmt->execute()) {
   echo "Updated successfully";
} else {
  echo "Error: " . $stmt->error;
}
   
} else {

$sql = "INSERT INTO water_tax 
(malmatta_no, year, jan_reading, feb_reading, mar_reading, april_reading, may_reading, 
jun_reading, jul_reading, aug_reading, sep_reading, oct_reading, nov_reading, dec_reading, 
pani_prakar, total_amount, panchayat_code, khasara_no, ittar_aakar) VALUES (
?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?,?,?
)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssssssssssisss", $malmatta_no, $year,
  $readings['jan'], $readings['feb'], $readings['mar'], $readings['april'], $readings['may'],
  $readings['jun'], $readings['jul'], $readings['aug'], $readings['sep'], $readings['oct'], 
  $readings['nov'], $readings['dec'], $pani_prakar, $total_amount, $_SESSION['panchayat_code'], $khasara_no, $ittar_akar
);

if ($stmt->execute()) {
  echo "Data inserted successfully.";
} else {
  echo "Error: " . $stmt->error;
}
}
