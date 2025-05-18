<?php
session_start(); // Start session to store messages
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($conn);


function generateUserId($prefix = "USR") {
    return $prefix . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $designation = $_POST['designation'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    if ($password !== $password_repeat) {
        echo "Passwords do not match.";
        exit;
    }
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }
  
    

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $state = $_POST['state'];
    $district_code = $_POST['district'];
    $panchayat_code = $_POST['panchayat'];
    $village_code = $_POST['village'];
    $user_id = generateUserId();
    // Check for existing user in district
    $stmt = $conn->prepare("SELECT id FROM users WHERE panchayat_code = ?");
    $stmt->bind_param("s", $panchayat_code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "A user already exists for this Panchayat.";
        exit;
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (user_id, name, mobile, email, designation, password, state, district_code, panchayat_code ,village_code)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
$stmt->bind_param("ssssssssss", $user_id, $name, $mobile, $email, $designation, $password, $state, $district_code, $panchayat_code ,$village_code);
    if ($stmt->execute()) {
        $_SESSION['message'] = "User registered successfully.";
        $_SESSION['user_id'] = $user_id;
        $_SESSION['message_type'] = "success";
        header("Location: ../register.php");
        echo "User registered successfully. </br>";
        echo "User ID: " . $user_id . "</br>";
        echo "Name: " . $name . "</br>";
        echo "Mobile: " . $mobile . "</br>";
        echo "Email: " . $email . "</br>";
        exit;
    } else {

        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['message_type'] = "error";
        header("Location: ../register.php");
        echo "Error: " . $stmt->error;
        exit;
    }
}
?>