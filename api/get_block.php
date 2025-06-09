<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$fun = new Fun($connect->dbConnect());

if (isset($_POST['district'])) {
    $state = $_POST['district'];
    $result = $fun->getUniqueBlock($state);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Block</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['Development_Block_Code']) . '">' . htmlspecialchars($row['Development_Block_Name']) . '</option>';
        }
    } else {
        echo '<option value="">No Block Found</option>';
    }

}
?>