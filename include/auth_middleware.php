<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: login.php");
    exit();
}
?>