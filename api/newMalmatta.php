<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['add'])) {
    // Main malmatta details
    $period_id         = trim($_POST['period']);
    $village_name      = trim($_POST['revenue_village']);
    $road_id           = trim($_POST['road_name']);
    $ward_id           = trim($_POST['ward_name']);
    $malmatta_no       = trim($_POST['malmatta_no']);
    $owner_id          = trim($_POST['owner_name']);
    $wife_id           = trim($_POST['owner_wife_name']);
    $occupant_id       = trim($_POST['occupant_name']);
    $city_survey_no    = trim($_POST['city_survey_no']);
    $group_number      = trim($_POST['group_number']);
    $toilet_available  = trim($_POST['toilet_available']);
    $remarks           = trim($_POST['remarks']);
    $lgdcode           = $_SESSION['district_code'];

    // Water usage details
    $drainage_type     = trim($_POST['drainage_type']);
    $tap_numbers       = trim($_POST['tap_numbers']);
    $tap_width         = trim($_POST['tap_width']);
    $tap_owner_id      = trim($_POST['tap_owner_name']);

    // Multiple property entries (JSON)
    $income_data       = isset($_POST['income_data']) ? json_decode($_POST['income_data'], true) : [];

    // Validate required fields
    if (empty($period_id) || empty($village_name) || empty($ward_id) || empty($malmatta_no) || empty($owner_id) || empty($occupant_id) || empty($toilet_available)) {
        $_SESSION['message'] = "⚠️ कृपया सर्व आवश्यक माहिती भरा!";
        $_SESSION['message_type'] = "warning";
        header("Location: ../Form_Malmatta_N8.php");
        exit();
    }

    try {
        // Insert main malmatta entry
        $malmatta_id = $fun->addMalmattaDataEntry(
            $period_id,
            $village_name,
            $ward_id,
            $road_id,
            $malmatta_no,
            $city_survey_no,
            $group_number,
            $toilet_available,
            $owner_id,
            $wife_id,
            $occupant_id,
            $remarks,
            $lgdcode
        );

        if (!$malmatta_id) {
            throw new Exception("❌ मुख्य मालमत्ता डेटा जतन करण्यात अयशस्वी!");
        }

        // Insert each dynamic property
        $all_properties_inserted = true;
        foreach ($income_data as $entry) {
            print_r($entry);
            
            $insert_property = $fun->addMalmattaPropertyInfo(
                $malmatta_id,
                $entry['incomeOtherInfo'] ?? '',
                $entry['taxableLand'] ?? '',
                $entry['incomeType'] ?? '',
                $entry['taxTypeId'] ?? '',
                $entry['redirecenarParts'] ?? '',
                $entry['construction_year_type'] ?? '',
                $entry['age'] ?? '',
                $entry['floors'] ?? '',
                $entry['selectedUnit'] ?? '',
                $entry['height'] ?? '',
                $entry['width'] ?? '',
                $entry['area'] ?? '',
                $entry['propertyUse'] ?? '',
            );
            if (!$insert_property) {
                $all_properties_inserted = false;
                break;
            }
        }

        if (!$all_properties_inserted) {
            throw new Exception("❌ काही मालमत्ता माहिती जतन करण्यात अयशस्वी!");
        }

        // Insert water tax info
        $water_added = $fun->addMalmattaWaterTax(
            $malmatta_id,
            $drainage_type,
            $tap_numbers,
            $tap_width,
            $tap_owner_id
        );

        if (!$water_added) {
            throw new Exception("❌ पाणी वापराचा डेटा जतन करण्यात अयशस्वी!");
        }

        $_SESSION['message'] = "✅ मालमत्ता यशस्वीरीत्या जतन केली गेली!";
        $_SESSION['message_type'] = "success";
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $_SESSION['message'] = "⚠️ ही मालमत्ता आधीच अस्तित्वात आहे!";
            $_SESSION['message_type'] = "warning";
        } else {
            $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage();
            $_SESSION['message_type'] = "error";
        }
    } catch (Exception $ex) {
        $_SESSION['message'] = $ex->getMessage();
        $_SESSION['message_type'] = "error";
    }

     header("Location: ../Form_Malmatta_N8.php");
    exit();
}

// Deletion logic
if (isset($_GET['delete'])) {
    $malmatta_id = $_GET['delete'];
    try {
        $deleted = $fun->deleteMalmatta($malmatta_id);
        if ($deleted) {
            $_SESSION['message'] = "✅ मालमत्ता यशस्वीरीत्या हटवली गेली!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "❌ मालमत्ता हटवण्यात अयशस्वी!";
            $_SESSION['message_type'] = "error";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
    }

    header("Location: ../Form_Malmatta_N8.php");
    exit();
}