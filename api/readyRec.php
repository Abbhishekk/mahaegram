<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $financialYear = trim($_POST['financialYear']);
        $villageName = trim($_POST['village_name']);
        $readyRecPart = trim($_POST['readyrec_part']);
        $landType = trim($_POST['land_type']);
        $yearlyTax = trim($_POST['yearly_tax']);
        $recordingType = isset($_POST['recording']) ? trim($_POST['recording']) : '';

        // Check if it's an update or new entry
        $updateId = isset($_POST['update']) && !empty($_POST['update']) ? $_POST['update'] : null;
        print_r($_POST);
        if ($updateId) {
            // Update existing record
            $updated = $fun->updateReadyrecInfo($updateId, $financialYear, $villageName, $readyRecPart, $landType, $recordingType, $yearlyTax);
            print_r($updated);
            if ($updated) {
                $_SESSION['message'] = "माहिती यशस्वीरित्या अद्ययावत केली!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "अद्ययावत करताना काहीतरी समस्या आली.";
                $_SESSION['message_type'] = "danger";
            }
        } else {
            // Insert new record
            $inserted = $fun->addReadyrecInfo($financialYear, $villageName, $readyRecPart, $landType, $recordingType,$yearlyTax);

            if ($inserted) {
                $_SESSION['message'] = "माहिती यशस्वीरित्या जतन केली!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "डेटा जतन करताना काहीतरी समस्या आली.";
                $_SESSION['message_type'] = "danger";
            }
        }
    }

    // Redirect back to the form
    header("Location: ../rediRecnorInfo.php");
    exit();
}
?>