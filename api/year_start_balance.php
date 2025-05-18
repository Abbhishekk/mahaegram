<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

try {
    
    if (!isset($_SESSION['district_code'])) {
        throw new Exception('District code not found in session');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'balance_type' => $_POST['balance_type'] ?? '',
            'financial_year' => $_POST['financial_year'] ?? '',
            'plan_name' => $_POST['plan_name'] ?? '',
            'bank_id' => !empty($_POST['bank_id']) ? $_POST['bank_id'] : null,
            'post_name' => $_POST['post_name'] ?? null,
            'post_branch' => $_POST['post_branch'] ?? null,
            'account_no' => $_POST['account_no'] ?? '',
            'ifsc_code' => $_POST['ifsc_code'] ?? '',
            'amount' => $_POST['amount'] ?? 0,
            'district_code' => $_SESSION['district_code'],
            'thev_yojana_name' => $_POST['theve_yojana_name'] ?? '',
        ];
        
        // Validate required fields
        $errors = [];
        if (empty($data['balance_type'])) $errors[] = 'शिल्लक प्रकार आवश्यक आहे';
        if (empty($data['financial_year'])) $errors[] = 'आर्थिक वर्ष आवश्यक आहे';
        if (empty($data['plan_name'])) $errors[] = 'योजनेचे नाव आवश्यक आहे';
        if (empty($data['amount']) || $data['amount'] <= 0) $errors[] = 'वैध रक्कम आवश्यक आहे';
        
        if (!empty($errors)) {
            throw new Exception(implode('<br>', $errors));
        }
        
        if (!empty($_POST['balance_id'])) {
            // Update existing balance
            $id = (int)$_POST['balance_id'];
            $success = $fun->updateYearStartBalance($id, $data);
            $message = $success ? 'शिल्लक माहिती यशस्वीरित्या अद्यतनित केली' : 'शिल्लक अद्यतनित करताना त्रुटी';
        } else {
            // Add new balance
            $success = $fun->addYearStartBalance($data);
            $message = $success ? 'शिल्लक माहिती यशस्वीरित्या जोडली' : 'शिल्लक जोडताना त्रुटी';
        }
        
        if ($success) {
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = 'success';
        } else {
            throw new Exception($message);
        }
        
        header('Location: ../namuna10_varshikkamkaj_shillak.php');
        exit;
    }
    
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $success = $fun->deleteYearStartBalance($id, $_SESSION['district_code']);
        
        if ($success) {
            $_SESSION['message'] = 'शिल्लक माहिती यशस्वीरित्या हटवली';
            $_SESSION['message_type'] = 'success';
        } else {
            throw new Exception('शिल्लक हटवताना त्रुटी');
        }
        
        header('Location: ../namuna10_varshikkamkaj_shillak.php');
        exit;
    }
    
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: ../namuna10_varshikkamkaj_shillak.php');
    exit;
}