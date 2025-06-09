<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false, 'message' => ''];
$conn = new Connect();
$conn = $conn->dbConnect();
$fun = new Fun($conn);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? 0;
        $userId = $_SESSION['user_id'] ?? null;

        if (empty($id)) {
            throw new Exception("अवैध पावती ID");
        }

        // Check if receipt exists
        $stmt = $pdo->prepare("SELECT * FROM karvasuli_records WHERE id = ?");
        $stmt->execute([$id]);
        $receipt = $stmt->fetch();

        if (!$receipt) {
            throw new Exception("पावती आढळली नाही");
        }

        // Mark as cancelled (you might want to create a cancelled_receipts table instead)
        $stmt = $conn->prepare("UPDATE karvasuli_records SET cancelled = 1, cancelled_by = ?, cancelled_at = NOW() WHERE id = ?");
        $stmt->execute([$userId, $id]);

        $response['success'] = true;
        $response['message'] = 'पावती यशस्वीरित्या रद्द केली गेली आहे';
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>