<?php
session_start(); // Start session to store messages
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users
        left join lgdtable on users.village_code = lgdtable.village_code and users.panchayat_code = lgdtable.Village_Panchayat_Code_TLB_Code and users.district_code = lgdtable.district_code
       
 WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['district_code'] = $row['district_code'];
            $_SESSION['district_name'] = $row['District_Name'];
            $_SESSION['village_code'] = $row['village_code'];
            $_SESSION['village_name'] = $row['Village_Name'];
            $_SESSION['panchayat_code'] = $row['Village_Panchayat_Code_TLB_Code'];
            $_SESSION['panchayat_name'] = $row['Village_Panchayat_Name_TLB_Name'];
            $_SESSION["block_code"] = $row['Development_Block_Code'];
            $_SESSION["block_name"] = $row['Development_Block_Name'];
            $_SESSION['message'] = "Login successful.";
            $_SESSION['state'] = $row['state'];
            echo "Login successful.";
            $_SESSION['message_type'] = "success";
            header("Location: ../index.php");
            exit;
        } else {
            echo "Invalid password.";
            $_SESSION['message'] = "Invalid password.";
            $_SESSION['message_type'] = "error";
            header("Location: ../login.php");
            exit;
        }
    } else {
        echo "No user found with this email.";
        $_SESSION['message'] = "No user found with this email.";
        $_SESSION['message_type'] = "error";
        header("Location: ../login.php");
        exit;
    }
}
?>