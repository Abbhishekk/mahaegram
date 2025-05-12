<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());
$wards = $fun->getWard($_SESSION['district_code']);

if (isset($_POST['add'])) {
    $ward_name = trim($_POST['ward_name']);
   $lgd_code = $_SESSION['district_code'];
    if (empty($ward_name)) {
        $_SESSION['message'] = "⚠️ कृपया वॉर्डचे नाव प्रविष्ट करा! (Please enter a ward name.)";
        $_SESSION['message_type'] = "warning";
        header("Location: ../wardMaster.php");
        exit();
    }

    if (isset($_POST['ward_no']) && $_POST['ward_no'] !== "") {
        // If ward number is provided, update the existing ward
        $ward_no = $_POST['ward_no'];
        try {
            $update = $fun->updateWard($ward_no, $ward_name);
    
            if ($update) {
                $_SESSION['message'] = "✅ बदललेली माहिती साठवली आहे! (Updated successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ वॉर्ड अपडेट करण्यात अयशस्वी! (Failed to update ward.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    } else {
        // If no ward number is provided, add a new ward
        $ward_no = $fun->getWardNo();
        try {
            $add = $fun->addWard($ward_no, $ward_name,$lgd_code);
    
            if ($add) {
                $_SESSION['message'] = "✅ वॉर्ड यशस्वीरीत्या जोडला गेला! (Ward added successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ वॉर्ड जोडण्यात अयशस्वी! (Failed to add ward.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    }

    header("Location: ../wardMaster.php");
    exit();
}

/**
 * Function to handle database errors and set session messages.
 */
function handleDatabaseError($e) {
    if ($e->getCode() == 1062) {  // Duplicate entry error
        $_SESSION['message'] = "⚠️ त्रुटी: हा वॉर्ड क्रमांक आधीच अस्तित्वात आहे! कृपया वेगळा क्रमांक वापरा. (Error: Ward number already exists! Please use a different ward number.)";
        $_SESSION['message_type'] = "warning";
    } else {
        $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage() . " (Database error)";
        $_SESSION['message_type'] = "error";
    }
}
?>