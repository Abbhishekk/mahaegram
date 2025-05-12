<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['add'])) {
    $road_name = trim($_POST['road_name']);

    if (empty($road_name)) {
        $_SESSION['message'] = "⚠️ कृपया रस्त्याचे नाव प्रविष्ट करा! (Please enter a road name.)";
        $_SESSION['message_type'] = "warning";
        header("Location: ../roadMaster.php");
        exit();
    }

    if (isset($_POST['update']) && $_POST['update'] !== "") {
        $road_no = $_POST['update'];
        try {
            $update = $fun->updateRoad($road_no, $road_name);
    
            if ($update) {
                $_SESSION['message'] = "✅ बदललेली रस्त्याची माहिती साठवली आहे! (Updated road details successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ रस्ता अपडेट करण्यात अयशस्वी! (Failed to update road.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    } else {
        try {
            $add = $fun->addRoad($road_name,$_SESSION['district_code']);
    
            if ($add) {
                $_SESSION['message'] = "✅ रस्ता यशस्वीरीत्या जोडला गेला! (Road added successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ रस्ता जोडण्यात अयशस्वी! (Failed to add road.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    }

    header("Location: ../roadMaster.php");
    exit();
}

/**
 * Function to handle database errors and set session messages.
 */
function handleDatabaseError($e) {
    if ($e->getCode() == 1062) {  // Duplicate entry error
        $_SESSION['message'] = "⚠️ त्रुटी: हा रस्ता क्रमांक आधीच अस्तित्वात आहे! कृपया वेगळा क्रमांक वापरा. (Error: Road number already exists! Please use a different road number.)";
        $_SESSION['message_type'] = "warning";
    } else {
        $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage() . " (Database error)";
        $_SESSION['message_type'] = "error";
    }
}
?>