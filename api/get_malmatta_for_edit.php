<?php
session_start();
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $fun->getMalmattaWithPropertiesWithIdNotApproved($id, $_SESSION['district_code']);
    $waterTax = $fun->getMalmattaWaterTaxByMalmattaId($id);
    if(mysqli_num_rows($waterTax) > 0) {
        $waterTaxData = mysqli_fetch_assoc($waterTax);
        $data[0]['water_tax'] = $waterTaxData;
    } else {
        $data[0]['water_tax'] = [];
    }
    if ($data) {
        echo json_encode([
            'success' => true,
            'malmatta' => $data[0],
            'properties' => $data[0]['properties'],
            'waterTax' => $data[0]['water_tax'],
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID not provided']);
}
?>