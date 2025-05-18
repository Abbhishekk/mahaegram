<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['malmatta_id'])) {
    $malmatta_id = intval($_POST['malmatta_id']);

    // Update database
    $approveProperty = $fun->approveMalmattaDataEntry($malmatta_id);

    if ($approveProperty) {
        $_SESSION['message'] = "मालमत्ता यशस्वीरित्या प्रमाणित करण्यात आली.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "प्रमाणित करताना त्रुटी आली.";
        $_SESSION['message_type'] = "danger";
    }

     header("Location: ../ApproveProperty.php"); // Change to actual file name
    exit;
}
?>