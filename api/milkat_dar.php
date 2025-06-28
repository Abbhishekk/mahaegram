<?php
session_start();

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $darData = [];
    if (isset($_POST['add'])) {
        $kaccheGhar = trim($_POST['decided_kache_ghar']);
        $minKaccheGhar = trim($_POST['minDar_kache_ghar']);
        $maxKaccheGhar = trim($_POST['maxDar_kache_ghar']);
        $constructionKaccheGhar = trim($_POST['construction_kache_ghar']);
        $ardhaPakke = trim($_POST['decided_ardha_pakke_ghar']);
        $minArdhaPakke = trim($_POST['minDar_ardha_pakke_ghar']);
        $maxArdhaPakke = trim($_POST['maxDar_ardha_pakke_ghar']);
        $constructionArdhaPakke = trim($_POST['construction_ardha_pakke_ghar']);
        $padsar = trim($_POST['decided_padsar']);
        $minPadsar = trim($_POST['minDar_padsar']);
        $maxPadsar = trim($_POST['maxDar_padsar']);
        $constructionPadsar = trim($_POST['construction_padsar']);

        $itarPakke = trim($_POST['decided_itar_pakke_ghar']);
        $minItarPakke = trim($_POST['minDar_itar_pakke_ghar']);
        $maxItarPakke = trim($_POST['maxDar_itar_pakke_ghar']);
        $constructionItarPakke = trim($_POST['construction_itar_pakke_ghar']);
        $rcc = trim($_POST['decided_rcc']);
        $minRcc = trim($_POST['minDar_rcc']);
        $maxRcc = trim($_POST['maxDar_rcc']);
        $constructionRcc = trim($_POST['construction_rcc']);
        $manoraType = trim($_POST['decided_manora_type_ghar']);
        $minManoraType = trim($_POST['minDar_manora_type_ghar']);
        $maxManoraType = trim($_POST['maxDar_manora_type_ghar']);
        $constructionManoraType = trim($_POST['construction_manora_type_ghar']);
        $manoraKhuliJagaSarvasadharan = trim($_POST['decided_manora_khuli_jaga_sarvasadharan']);
        $minManoraKhuliJagaSarvasadharan = trim($_POST['minDar_manora_khuli_jaga_sarvasadharan']);
        $maxManoraKhuliJagaSarvasadharan = trim($_POST['maxDar_manora_khuli_jaga_sarvasadharan']);
        $constructionManoraKhuliJagaSarvasadharan = trim($_POST['construction_manora_khuli_jaga_sarvasadharan']);
        $manoraKhuliJagaMNC = trim($_POST['decided_manora_khuli_jaga_mnc']);
        $minManoraKhuliJagaMNC = trim($_POST['minDar_manora_khuli_jaga_mnc']);
        $maxManoraKhuliJagaMNC = trim($_POST['maxDar_manora_khuli_jaga_mnc']);
        $constructionManoraKhuliJagaMNC = trim($_POST['construction_manora_khuli_jaga_mnc']);
        $lgd_code = trim($_SESSION['district_code']);
        $dar = "fixed";
        $minDar = "min";
        $maxDar = "max";
        $constructionDar = "construction";

        $darData["decided"] = [
            "kacche_ghar" => $kaccheGhar,
            "ardha_pakke_ghar" => $ardhaPakke,
            "padsar" => $padsar,
            "itar_pakke_ghar" => $itarPakke,
            "rcc" => $rcc,
            "manora_type_ghar" => $manoraType,
            "manora_khuli_jaga_sarvasadharan" => $manoraKhuliJagaSarvasadharan,
            "manora_khuli_jaga_mnc" => $manoraKhuliJagaMNC,
            "dar" => $dar
        ];

        $darData["min"] = [
            "kacche_ghar" => $minKaccheGhar,
            "ardha_pakke_ghar" => $minArdhaPakke,
            "padsar" => $minPadsar,
            "itar_pakke_ghar" => $minItarPakke,
            "rcc" => $minRcc,
            "manora_type_ghar" => $minManoraType,
            "manora_khuli_jaga_sarvasadharan" => $minManoraKhuliJagaSarvasadharan,
            "manora_khuli_jaga_mnc" => $minManoraKhuliJagaMNC,
            "dar" => $minDar
        ];
        
        $darData["max"] = [
            "kacche_ghar" => $maxKaccheGhar,
            "ardha_pakke_ghar" => $maxArdhaPakke,
            "padsar" => $maxPadsar,
            "itar_pakke_ghar" => $maxItarPakke,
            "rcc" => $maxRcc,
            "manora_type_ghar" => $maxManoraType,
            "manora_khuli_jaga_sarvasadharan" => $maxManoraKhuliJagaSarvasadharan,
            "manora_khuli_jaga_mnc" => $maxManoraKhuliJagaMNC,
            "dar" => $maxDar
        ];

        $darData["construction"] = [
            "kacche_ghar" => $constructionKaccheGhar,
            "ardha_pakke_ghar" => $constructionArdhaPakke,
            "padsar" => $constructionPadsar,
            "itar_pakke_ghar" => $constructionItarPakke,
            "rcc" => $constructionRcc,
            "manora_type_ghar" => $constructionManoraType,
            "manora_khuli_jaga_sarvasadharan" => $constructionManoraKhuliJagaSarvasadharan,
            "manora_khuli_jaga_mnc" => $constructionManoraKhuliJagaMNC,
            "dar" => $constructionDar
        ];
        // Check if it's an update or new entry
        $updateId = isset($_POST['update']) && !empty($_POST['update']) ? $_POST['update'] : null;
        $isPresent = $fun->isMilkatTaxInfoExists($lgd_code, $dar);
        if ($isPresent) {
            // Update existing record
          
                $_SESSION['message'] = "अद्ययावत करताना काहीतरी समस्या आली.";
                $_SESSION['message_type'] = "danger";
        
        } else {
            // Insert new record
            foreach ($darData as $key => $value) {
                $dar = $value['dar'];
                $kaccheGhar = $value['kacche_ghar'];
                $ardhaPakke = $value['ardha_pakke_ghar'];
                $padsar = $value['padsar'];
                $itarPakke = $value['itar_pakke_ghar'];
                $rcc = $value['rcc'];
                $manoraType = $value['manora_type_ghar'];
                $manoraKhuliJagaSarvasadharan = $value['manora_khuli_jaga_sarvasadharan'];
                $manoraKhuliJagaMNC = $value['manora_khuli_jaga_mnc'];
        $isPresent = $fun->isMilkatTaxInfoExists($lgd_code, $dar);
            if ($isPresent) {
                continue; // Skip if record already exists
            }else{
                $inserted = $fun->addMilkatTaxInfo($lgd_code, $_SESSION['panchayat_code'] ,$dar,$kaccheGhar, $ardhaPakke, $padsar, $itarPakke, $rcc, $manoraType, $manoraKhuliJagaSarvasadharan, $manoraKhuliJagaMNC);
            }
            }

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