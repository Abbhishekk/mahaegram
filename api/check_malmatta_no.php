<?php
    session_start();
header('Content-Type: application/json');

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());
$response = ['success' => false, 'message' => ''];


if (isset($_GET['malmatta_no']) && isset($_GET['district_code'])) {
    $malmatta_no = $_GET['malmatta_no'];
    $district_code = $_GET['district_code'];
    
    // Check if malmatta number exists
   //
    $result = $fun->getMalmattaDataEntryByMalmattaNo($malmatta_no, $district_code);
    
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['available' => false, 'message' => 'मालमत्ता क्रमांक आधीपासून वापरात आहे']);
    } else {
        echo json_encode(['available' => true, 'message' => 'मालमत्ता क्रमांक उपलब्ध आहे']);
    }
}
?>