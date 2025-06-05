<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

header('Content-Type: application/json');

$response = ['success' => false, 'owner_name' => '', 'occupant_name' => ''];

$connect = new Connect();
$fun = new Fun($connect->dbConnect());
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['malmattaId'])) {
    $malmatta_id = $_POST['malmattaId'];

    $property = $fun->getMalmattaDataEntryById($malmatta_id, $_SESSION['district_code']);
    // print_r($property);
    if (mysqli_num_rows($property) > 0) {
        $property = mysqli_fetch_assoc($property);
    } else {
        $property = null;
    }
    if ($property) {
        $response = [
            'success' => true,
            'owner_name' => $property['owner_name'] ?? '',
            'occupant_name' => $property['occupant_name'] ?? ''
        ];
    }
}

echo json_encode($response);
