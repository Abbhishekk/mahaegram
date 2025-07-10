<?php
session_start(); // Start session to store messages
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($conn);

$action = $_POST['action'] ?? '';

if ($action === 'save') {
    $register_no = $_POST['register_no'] ?? '';
    $malmatta_ids = $_POST['malmatta_no'] ?? [];
    $district_code = $_SESSION['district_code'];
    $panchayat_code = $_SESSION['panchayat_code'];

    if (empty($register_no)) {
        echo json_encode(['success' => false, 'msg' => 'रजिस्टर क्रमांक आणि मिळकत क्रमांक आवश्यक आहेत']);
        exit;
    }

    // Remove existing mappings
    $delete = "DELETE FROM register_malmatta_map WHERE register_no = ? AND panchayat_code = ?";
    $stmt = $conn->prepare($delete);
    $stmt->bind_param("ss", $register_no, $panchayat_code);
    $stmt->execute();

    // Insert new mappings
    $insert = "INSERT INTO register_malmatta_map (register_no, malmatta_id, panchayat_code) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert);
    if(empty($malmatta_ids)) {
        $mid = 0;
        $stmt->bind_param("sis", $register_no, $mid, $panchayat_code);
        $stmt->execute();
    }
    foreach ($malmatta_ids as $mid) {
        $stmt->bind_param("sis", $register_no, $mid, $panchayat_code);
        $stmt->execute();
    }

    echo json_encode(['success' => true, 'msg' => 'नोंद साठवली गेली.']);
    exit;
}

if ($action === 'fetch') {
    $register_no = $_POST['register_no'] ?? '';
    $district_code = $_SESSION['district_code'];
    $panchayat_code = $_SESSION['panchayat_code'];

    $query = "SELECT malmatta_id FROM register_malmatta_map WHERE register_no = ? AND panchayat_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $register_no, $panchayat_code);
    $stmt->execute();
    $result = $stmt->get_result();

    $malmatta_ids = [];
    while ($row = $result->fetch_assoc()) {
        $malmatta_ids[] = $row['malmatta_id'];
    }

    echo json_encode(['success' => true, 'malmatta_ids' => $malmatta_ids]);
    exit;
}

echo json_encode(['success' => false, 'msg' => 'Invalid request']);
exit;
