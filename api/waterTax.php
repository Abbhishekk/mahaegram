<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['add'])) {
    $drainageType = trim($_POST['drainageType']);
    $period = trim($_POST['period']);
    $min_tax = trim($_POST['min_tax']);
    $max_tax = trim($_POST['max_tax']);
    $fixed_tax = trim($_POST['fixed_tax']);
    $pip_connection = trim($_POST['pip_connection']);
    $decision_date = trim($_POST['decision_date']);
    $resolution_no = trim($_POST['resolution_no']);
    // print_r($_POST);
    if (empty($drainageType) || empty($period) || empty($min_tax) || empty($fixed_tax) || empty($pip_connection) || empty($decision_date) || empty($resolution_no) || empty($max_tax)) {
        $_SESSION['message'] = "⚠️ कृपया सर्व माहिती भरा! (Please fill in all details.)";
        $_SESSION['message_type'] = "warning";
        header("Location: ../waterTaxRateInfo.php");
        exit();
    }

    if (isset($_POST['update']) && $_POST['update'] !== "") {
        $tariff_id = $_POST['update'];
        try {
            $update = $fun->updateWaterTariff($tariff_id, $drainageType, $period, $min_tax, $fixed_tax, $pip_connection, $decision_date, $resolution_no,$max_tax);
             print_r($update);
            if ($update) {
                $_SESSION['message'] = "✅ पाणीपट्टीची माहिती यशस्वीरित्या अद्ययावत केली! (Updated water tariff successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ पाणीपट्टी अद्ययावत करण्यात अयशस्वी! (Failed to update water tariff.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    } else {
        try {
            $add = $fun->addWaterTariff($drainageType, $period, $min_tax, $fixed_tax, $pip_connection, $decision_date, $resolution_no, $max_tax, $_SESSION['district_code']);
    // print_r($add);
            if ($add) {
                $_SESSION['message'] = "✅ पाणीपट्टी यशस्वीरीत्या जोडली गेली! (Water tariff added successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ पाणीपट्टी जोडण्यात अयशस्वी! (Failed to add water tariff.)";
                $_SESSION['message_type'] = "error";
            }
        } catch (mysqli_sql_exception $e) {
            handleDatabaseError($e);
        }
    }

      header("Location: ../waterTaxRateInfo.php");
    exit();
}

/**
 * Function to handle database errors and set session messages.
 */
function handleDatabaseError($e) {
    if ($e->getCode() == 1062) {  // Duplicate entry error
        $_SESSION['message'] = "⚠️ त्रुटी: हाच पाणीपट्टी दर आधीच अस्तित्वात आहे! (This water tariff already exists!)";
        $_SESSION['message_type'] = "warning";
    } else {
        $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
    }
    header("Location: ../waterTaxRateInfo.php");
    exit();
}