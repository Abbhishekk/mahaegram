<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $personName = trim($_POST['person_name']);
        $nickname = trim($_POST['nickname']);
        $gender = trim($_POST['gender']);
        $mobileNo = trim($_POST['mobile_no']);
        $aadharNo = trim($_POST['aadhar_no']);
        $email = trim($_POST['email']);

        // Check if it's an update or new entry
        $updateId = isset($_POST['update']) && !empty($_POST['update']) ? $_POST['update'] : null;

        if ($updateId) {
            // Update existing record
            $updated = $fun->updateNewName($updateId, $personName, $nickname, $gender, $mobileNo, $aadharNo, $email);

            if ($updated) {
                $_SESSION['message'] = "माहिती यशस्वीरित्या अद्ययावत केली!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "अद्ययावत करताना काहीतरी समस्या आली.";
                $_SESSION['message_type'] = "danger";
            }
        } else {
            // Insert new record
            $inserted = $fun->addNewName($personName, $nickname, $gender, $mobileNo, $aadharNo, $email);

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
    header("Location: ../Form_Name_Masters.php");
    exit();
}