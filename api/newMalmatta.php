<?php
session_start();
header('Content-Type: application/json');

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());
$response = ['success' => false, 'message' => ''];

try {
    // Validate request method and action
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['add'])) {
        throw new Exception("Invalid request method");
    }

    // Validate and sanitize input data
    $requiredFields = [
        'period' => 'period',
        'revenue_village' => 'revenue_village',
        'ward_name' => 'ward_name',
        'malmatta_no' => 'malmatta_no',
        'owner_name' => 'owner_name',
        'occupant_name' => 'occupant_name',
        'toilet_available' => 'toilet_available'
    ];

    $data = [];
    foreach ($requiredFields as $key => $field) {
        $data[$key] = trim($_POST[$field] ?? '');
        if (empty($data[$key])) {
            throw new Exception("⚠️ कृपया सर्व आवश्यक माहिती भरा!");
        }
    }

    // Collect additional data
    $additionalFields = [
        'road_name', 'owner_wife_name', 'city_survey_no', 'group_number', 'remarks',
        'drainage_type', 'tap_numbers', 'tap_width', 'tap_owner_name'
    ];

    foreach ($additionalFields as $field) {
        $data[$field] = trim($_POST[$field] ?? '');
    }

    $data['lgdcode'] = $_SESSION['district_code'] ?? '';

    // Process property data
    $income_data = [];
    if (!empty($_POST['income_data'])) {
        $income_data = json_decode($_POST['income_data'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("❌ Invalid property data format");
        }
    }

    // Begin database transaction
    $connect->dbConnect()->begin_transaction();

    try {
        // Insert main malmatta entry
        $malmatta_id = $fun->addMalmattaDataEntry(
            $data['period'],
            $data['revenue_village'],
            $data['ward_name'],
            $data['road_name'],
            $data['malmatta_no'],
            $data['city_survey_no'],
            $data['group_number'],
            $data['toilet_available'],
            $data['owner_name'],
            $data['owner_wife_name'],
            $data['occupant_name'],
            $data['remarks'],
            $data['lgdcode']
        );

        if (!$malmatta_id) {
            throw new Exception("❌ मुख्य मालमत्ता डेटा जतन करण्यात अयशस्वी!");
        }

        // Process each property
        foreach ($income_data as $index => $entry) {
            $photoPath = processPropertyPhoto($index, $entry);
            
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
                $photoPath
            );

            if (!$insert_property) {
                throw new Exception("❌ मालमत्ता माहिती जतन करण्यात अयशस्वी");
            }
        }

        // Insert water tax info
        $water_added = $fun->addMalmattaWaterTax(
            $malmatta_id,
            $data['drainage_type'],
            $data['tap_numbers'],
            $data['tap_width'],
            $data['tap_owner_name']
        );

        if (!$water_added) {
            throw new Exception("❌ पाणी वापराचा डेटा जतन करण्यात अयशस्वी!");
        }

        // Commit transaction if everything succeeds
        $connect->dbConnect()->commit();

        $response = [
            'success' => true,
            'message' => "✅ मालमत्ता यशस्वीरीत्या जतन केली गेली!",
            'redirect' => "Form_Malmatta_N8.php"
        ];

        // Store in session for non-AJAX fallback
        $_SESSION['message'] = $response['message'];
        $_SESSION['message_type'] = "success";

    } catch (Exception $e) {
        $connect->dbConnect()->rollback();
        throw $e; // Re-throw to outer catch block
    }

} catch (mysqli_sql_exception $e) {
    $response['message'] = ($e->getCode() == 1062) ? 
        "⚠️ ही मालमत्ता आधीच अस्तित्वात आहे!" : 
        "❌ डेटाबेस त्रुटी: " . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Clean output buffer and return JSON response
ob_clean();
echo json_encode($response);
exit();

/**
 * Process property photo upload (either file upload or base64)
 */
 function processPropertyPhoto($index, $entry) {
    $photoPath = null;
    $uploadDir = '../uploads/property_photos/';
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Handle file upload
    if (isset($_FILES['property_photos']['tmp_name'][$index])) {
        $tmpName = $_FILES['property_photos']['tmp_name'][$index];
        $fileName = basename($_FILES['property_photos']['name'][$index]);
        $filePath = $uploadDir . uniqid() . '_' . $fileName;
        
        if (move_uploaded_file($tmpName, $filePath)) {
            $photoPath = 'uploads/property_photos/' . basename($filePath);
        }
    }
    // Handle base64 image
    elseif (!empty($entry['propertyPhoto'])) {
        $photoData = $entry['propertyPhoto'];
        $fileName = uniqid('property_') . '_' . ($entry['photoName'] ?? 'property.jpg');
        $filePath = $uploadDir . $fileName;
        
        if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
            $photoData = substr($photoData, strpos($photoData, ',') + 1);
            $photoData = base64_decode($photoData);
            
            if ($photoData !== false && file_put_contents($filePath, $photoData)) {
                $photoPath = 'uploads/property_photos/' . $fileName;
            }
        }
    }
    
    return $photoPath;
}

// Handle deletion separately
if (isset($_GET['delete'])) {
    try {
        $malmatta_id = (int)$_GET['delete'];
        $deleted = $fun->deleteMalmatta($malmatta_id);
        
        $_SESSION['message'] = $deleted ? 
            "✅ मालमत्ता यशस्वीरीत्या हटवली गेली!" : 
            "❌ मालमत्ता हटवण्यात अयशस्वी!";
        $_SESSION['message_type'] = $deleted ? "success" : "error";
        
    } catch (Exception $e) {
        $_SESSION['message'] = "❌ डेटाबेस त्रुटी: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
    }
    
    header("Location: ../Form_Malmatta_N8.php");
    exit();
}