<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $kaccheGhar = trim($_POST['decided_kache_ghar']);
        $ardhaPakke = trim($_POST['decided_ardha_pakke_ghar']);
        $padsar = trim($_POST['decided_padsar']);
        $itarPakke = trim($_POST['decided_itar_pakke_ghar']);
        $rcc = trim($_POST['decided_rcc']);
        $manoraType = trim($_POST['decided_manora_type_ghar']);
        $manoraKhuliJagaSarvasadharan = trim($_POST['decided_manora_khuli_jaga_sarvasadharan']);
        $manoraKhuliJagaMNC = trim($_POST['decided_manora_khuli_jaga_mnc']);
        $lgd_code = trim($_SESSION['district_code']);
        $dar = "fixed";
        // Check if it's an update or new entry
        $updateId = isset($_POST['update']) && !empty($_POST['update']) ? $_POST['update'] : null;
        $isPresent = $fun->isMilkatTaxInfoExists($lgd_code, $dar);
        if ($isPresent) {
            // Update existing record
          
                $_SESSION['message'] = "अद्ययावत करताना काहीतरी समस्या आली.";
                $_SESSION['message_type'] = "danger";
        
        } else {
            // Insert new record
            $inserted = $fun->addMilkatTaxInfo($lgd_code, $dar,$kaccheGhar, $ardhaPakke, $padsar, $itarPakke, $rcc, $manoraType, $manoraKhuliJagaSarvasadharan, $manoraKhuliJagaMNC);

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
    header("Location: ../valmitkar_darMaster.php");
    exit();
}