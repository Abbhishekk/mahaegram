<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['add'])) {
    $reason = trim($_POST['reason']);
    $reasons = $fun->getDurationReasonById($reason);
    if ($reasons) {
        $reason = $reasons['reason'];
    } else {
        $_SESSION['message'] = "⚠️ कालावधी कारण सापडले नाही! (Duration reason not found!)";
        $_SESSION['message_type'] = "error";
        header("Location: ../durationMaster.php");
        exit();
    }
    $duration_start = trim($_POST['durationStart']);
    $duration_end = trim($_POST['durationEnd']);
    $total_duration = trim($_POST['duration']);

    if (empty($reason) || empty($duration_start) || empty($duration_end) || empty($total_duration)) {
        $_SESSION['message'] = "⚠️ कृपया सर्व माहिती भरा! (Please fill in all details.)";
        $_SESSION['message_type'] = "warning";
        header("Location: ../durationMaster.php");
        exit();
    }

    if (isset($_POST['update']) && $_POST['update'] !== "") {
        $duration_id = $_POST['update'];
        try {
            $update = $fun->updatePeriodDetails($duration_id, $reason, $duration_start, $duration_end, $total_duration);
    
            if ($update) {
                $_SESSION['message'] = "✅ कालावधीची माहिती यशस्वीरित्या अद्ययावत केली! (Updated duration details successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ कालावधी अद्ययावत करण्यात अयशस्वी! (Failed to update duration.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    } else {
        try {
            $add = $fun->addPeriodDetails($reason, $duration_start, $duration_end, $total_duration, $_SESSION['district_code']);
    
            if ($add) {
                $_SESSION['message'] = "✅ कालावधी यशस्वीरीत्या जोडला गेला! (Duration added successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ कालावधी जोडण्यात अयशस्वी! (Failed to add duration.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    }

    header("Location: ../durationMaster.php");
    exit();
}

/**
 * Function to handle database errors and set session messages.
 */
function handleDatabaseError($e) {
    if ($e->getCode() == 1062) {  // Duplicate entry error
        $_SESSION['message'] = "⚠️ त्रुटी: हाच कालावधी आधीच अस्तित्वात आहे! कृपया वेगळे मूल्य वापरा. (Error: Duration already exists! Please use a different value.)";
        $_SESSION['message_type'] = "warning";
    } else {
        $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage() . " (Database error)";
        $_SESSION['message_type'] = "error";
    }
}