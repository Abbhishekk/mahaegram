<?php
require_once "include/connect/db.php";
require_once "include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Functions($db);

file_put_contents("debug_blocks.txt", json_encode($_POST) . "\n", FILE_APPEND);
// $_POST['district'] = 'Akola';
if (isset($_POST['district']) && !empty($_POST['district'])) {
    $district = $_POST['district'];
    // $district = 'Akola';
    $blocks = $fun->fetch_blocks($district);

    file_put_contents("debug_blocks.txt", "Fetched: " . json_encode($blocks) . "\n", FILE_APPEND);

    echo '<option value="">-- तालुका निवडा --</option>';
    foreach ($blocks as $block) {
        echo "<option value='$block'>$block</option>";
    }
} else {
    echo '<option value="">⚠ जिल्हा रिकामे</option>';
}
