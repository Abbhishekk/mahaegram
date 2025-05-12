<?php
session_start(); // Start session to store messages
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['district'])) {
    $district = $_POST['district'];
    $result = $fun->getVillagesWithDistrict($district);

    if ($result->num_rows == 0) {
        echo '<option value="">No Villages Found</option>';
        return;
    }

    echo '<option value="">Select Village</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['Village_Code']) . '">' . htmlspecialchars($row['Village_Name']) . '</option>';
    }
}
?>