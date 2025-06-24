<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['add'])) {
    // print_r($_POST);
    $decision_date = $_POST['decisionDate'];
    $period = $_POST['period'];
    $decisionDate = $_POST['decisionDate'];
    $decisionNo = $_POST['descisionNo'];
    $isHealthTaxChecked = isset($_POST['healthTax']) ? 1 : 0;
    $isLightTaxChecked = isset($_POST['lightTax']) ? 1 : 0;
    $isSafaiTaxChecked = isset($_POST['safaiTax']) ? 1 : 0;
    print_r($_POST);
    $health = $_POST['health'];
$divabatti = $_POST['divabatti'];
$safai = $_POST['safai'];

$merged = [];
foreach ($health as $key => $healthRow) {
    $divabattiRow = $divabatti[$key] ?? [];
    $safaiRow = $safai[$key] ?? [];
    // If health tax is checked, zero out all health-related values
    if ($isHealthTaxChecked) {
        $healthRow['kiman_rate'] = 0;
        $healthRow['kamal_rate'] = 0;
        $healthRow['tharabaila_rate'] = 0;
    }

    // If light tax is checked, zero out all divabatti-related values
    if ($isLightTaxChecked) {
        $divabattiRow['kiman_rate'] = 0;
        $divabattiRow['kamal_rate'] = 0;
        $divabattiRow['tharabaila_rate'] = 0;
    }

    if($isSafaiTaxChecked){
        $safaiRow['safai_kiman_rate'] = 0;
        $safaiRow['safai_kamal_rate'] = 0;
        $safaiRow['safai_tharabaila_rate'] = 0;
    }

    

    $merged[] = [
        'id' => $key,
        'health_kiman_rate' => $healthRow['kiman_rate'] ?? 0,
        'health_kamal_rate' => $healthRow['kamal_rate'] ?? 0,
        'health_tharabaila_rate' => $healthRow['tharabaila_rate'] ?? 0,
        'divabatti_kiman_rate' => $divabattiRow['kiman_rate'] ?? 0,
        'divabatti_kamal_rate' => $divabattiRow['kamal_rate'] ?? 0,
        'divabatti_tharabaila_rate' => $divabattiRow['tharabaila_rate'] ?? 0,
        'safai_kiman_rate' => $safaiRow['kiman_rate'] ?? 0,
        'safai_kamal_rate' => $safaiRow['kamal_rate'] ?? 0,
        'safai_tharabaila_rate' => $safaiRow['tharabaila_rate'] ?? 0
    ];
}

print_r($merged);
    
    $getInfoByPeriod = $fun->getTharavByPeriod($period);

    if ($getInfoByPeriod->num_rows > 0) {
        $_SESSION['message'] = "⚠️ त्रुटी: हाच कालावधी आधीच अस्तित्वात आहे! कृपया वेगळे मूल्य वापरा. (Error: This period already exists! Please use a different value.)";
        $_SESSION['message_type'] = "warning";
        header("Location: ../HealthAndLightTax.php");
        exit();
    }
    // if (empty($decision_date) || empty($period) || empty($decisionNo) || empty($decision)) {
    //     $_SESSION['message'] = "⚠️ कृपया सर्व माहिती भरा! (Please fill in all details.)";
    //     $_SESSION['message_type'] = "warning";
    //     header("Location: ../HealthAndLightTax.php");
    //     exit();
    // }
    try {
        $add = $fun->addTharav($decision_date, $decisionNo, $period, $_SESSION['district_code']);
     
        if ($add) {
            $_SESSION['message'] = "✅ कालावधी यशस्वीरीत्या जोडला गेला! (Duration added successfully!)";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "❌ कालावधी जोडण्यात अयशस्वी! (Failed to add duration.)";
            $_SESSION['message_type'] = "error";
        }
        if ($add) {
            $addTaxInfo = false;
            try{
                foreach ($merged as $row) {
                   
                    try {
                        //code...
                        $update= $fun->updateTaxInfo($row['id'], $row['health_kiman_rate'], $row['health_kamal_rate'], $row['health_tharabaila_rate'], $row['divabatti_kiman_rate'], $row['divabatti_kamal_rate'], $row['divabatti_tharabaila_rate'], $row['safai_kiman_rate'], $row['safai_kamal_rate'], $row['safai_tharabaila_rate'],$decisionNo);
                    } catch (mysqli_sql_exception $e) {
                        //throw $th;
                        handleDatabaseError($e);
                        
                    }
                    
                }
                $addtaxInfo = true;
            } catch (mysqli_sql_exception $e) {
                handleDatabaseError($e);
              
            }
           
            if ($addTaxInfo) {
                $_SESSION['message'] = "✅ कालावधी यशस्वीरीत्या जोडला गेला! (Duration added successfully!)";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "❌ कालावधी जोडण्यात अयशस्वी! (Failed to add duration.)";
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "❌ कालावधी जोडण्यात अयशस्वी! (Failed to add duration.)";
            $_SESSION['message_type'] = "error";
        }
        header("Location: ../HealthAndLightTax.php");
        exit();
    }
    catch (mysqli_sql_exception $e) {
        handleDatabaseError($e);
    }

    } else {
    $_SESSION['message'] = "❌ त्रुटी: कृपया सर्व आवश्यक माहिती भरा! (Error: Please fill in all required information!)";
    $_SESSION['message_type'] = "error";
   header("Location: ../HealthAndLightTax.php");
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