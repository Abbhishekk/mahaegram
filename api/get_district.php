<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['state'])) {
    $state = $_POST['state'];
    $result = $fun->getUniqueDistricts($state);
    if ($result->num_rows > 0) {
        echo '<option value="">Select District</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['District_Code']) . '">' . htmlspecialchars($row['District_Name']) . '</option>';
        }
    } else {
        echo '<option value="">No Districts Found</option>';
    }

}
?>