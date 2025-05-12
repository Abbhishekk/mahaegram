<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());
print_r($_POST);
if (isset($_POST['add'])) {
    $period = trim($_POST['period']);
    $ward_no = trim($_POST['ward_name']);
    $village_name = trim($_POST['revenue_village']);
    $street_name = trim($_POST['road_name']);
    $malmatta_no = trim($_POST['malmatta_no']);
    $owner_name = trim($_POST['owner_name']);
    $owner_wife_name = trim($_POST['owner_wife_name']);
    $occupant_name = trim($_POST['occupant_name']);
    $mobile_no = trim($_POST['mobile_no']);
    $city_survey_no = trim($_POST['city_survey_no']);
    $group_number = trim($_POST['group_number']);
    $drainage_type = trim($_POST['drainage_type']);
    $toilet_available = trim($_POST['toilet_available']);


    if (empty($period) || empty($ward_no) || empty($village_name) || empty($street_name) || empty($malmatta_no) || empty($owner_name) || empty($owner_wife_name) || empty($occupant_name) || empty($mobile_no) || empty($city_survey_no) || empty($group_number) || empty($drainage_type) || empty($toilet_available)) {
        $_SESSION['message'] = "⚠️ कृपया सर्व माहिती भरा! (Please fill in all details.)";
        $_SESSION['message_type'] = "warning";
        header("Location: ../Malmatta.php");
        exit();
    }

    if (isset($_POST['update']) && $_POST['update'] !== "") {
        $property_id = $_POST['update'];
        try {
            $update = $fun->updateMalmatta($property_id, $_POST);
    
            if ($update) {
                $_SESSION['message'] = "✅ मालमत्ता माहिती यशस्वीरित्या अद्ययावत केली! (Property details updated successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ मालमत्ता अद्ययावत करण्यात अयशस्वी! (Failed to update property details.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    } else {
        try {
            $add = $fun->createMalmatta($_POST);
    
            if ($add) {
                $_SESSION['message'] = "✅ मालमत्ता यशस्वीरीत्या जोडली गेली! (Property added successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ मालमत्ता जोडण्यात अयशस्वी! (Failed to add property.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    }

    header("Location: ../Malmatta.php");
    exit();
}

/**
 * Function to handle database errors and set session messages.
 */
function handleDatabaseError($e) {
    if ($e->getCode() == 1062) {  // Duplicate entry error
        $_SESSION['message'] = "⚠️ त्रुटी: हाच मालमत्ता क्रमांक आधीच अस्तित्वात आहे! कृपया वेगळे मूल्य वापरा. (Error: Property number already exists! Please use a different value.)";
        $_SESSION['message_type'] = "warning";
    } else {
        $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage() . " (Database error)";
        $_SESSION['message_type'] = "error";
    }
}