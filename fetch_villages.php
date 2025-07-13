<?php
require_once "include/connect/db.php";
require_once "include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Functions($db);


if (isset($_POST['block'])) {
    $block = $_POST['block'];
    $villages = $fun->fetch_villages($block);

    echo '<option value="">-- ग्रामपंचायत निवडा --</option>';
    foreach ($villages as $village) {
        echo '<option value="' . $village . '">' . $village . '</option>';
    }
    
}
file_put_contents("log.txt", json_encode($_POST) . PHP_EOL, FILE_APPEND);
