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

        // Validate inputs
        $errors = [];

        // Name validation
        if (empty($personName)) {
            $errors[] = "व्यक्तीचे नाव आवश्यक आहे.";
        }
        // elseif (!preg_match("/^[\p{Marathi} ]+$/u", $personName)) {
        //     $errors[] = "व्यक्तीचे नाव फक्त मराठी अक्षरे असावे.";
        // }

        // Mobile number validation (10 digits, starts with 6-9)
        if (empty($mobileNo)) {
            $errors[] = "मोबाईल नंबर आवश्यक आहे.";
        } elseif (!preg_match("/^[6-9][0-9]{9}$/", $mobileNo)) {
            $errors[] = "कृपया वैध मोबाईल नंबर प्रविष्ट करा (10 अंक, 6,7,8 किंवा 9 ने सुरू).";
        }

        // Aadhaar validation (12 digits, can have spaces or hyphens)
        if (!empty($aadharNo)) {
            $cleanedAadhar = preg_replace('/[-\s]/', '', $aadharNo);
            if (!preg_match("/^[0-9]{12}$/", $cleanedAadhar)) {
                $errors[] = "कृपया वैध आधार क्रमांक प्रविष्ट करा (12 अंक).";
            }
            $aadharNo = $cleanedAadhar; // Store cleaned version
        }

        // Email validation
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "कृपया वैध ईमेल पत्ता प्रविष्ट करा.";
        }

        // Check if there are any validation errors
        if (!empty($errors)) {
            $_SESSION['message'] = implode("<br>", $errors);
            $_SESSION['message_type'] = "danger";
            header("Location: ../Form_Name_Masters.php");
            exit();
        }
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
    header("Location: ../Form_Malmatta_N8.php");
    exit();
}