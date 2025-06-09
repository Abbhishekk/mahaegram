<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false, 'data' => []];
$conn = new Connect();
$conn = $conn->dbConnect();
$fun = new Fun($conn);
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $financialYear = $_POST['financial_year'] ?? '';
        $panchayatCode = $_SESSION['panchayat_code'];

        $query = "SELECT DISTINCT kr.malamatta_kramanak as id, kr.malamatta_kramanak as number 
                  FROM karvasuli_records kr
                    left join tax_demands td on kr.malamatta_kramanak = td.malmatta_id
         left OUTER join malmatta_data_entry mde on mde.id =  td.malmatta_id
         LEFT outer join new_name nn1 on kr.kar_denaryache_nav = nn1.id
        LEFT outer join new_name nn2 on mde.occupant_name = nn2.id
                  WHERE mde.panchayat_code = $panchayatCode";

        $params = [':panchayat_code' => $panchayatCode];

        if ($financialYear) {
            $query .= " AND td.financial_year = $financialYear";
            $params[':financial_year'] = $financialYear;
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $response['data'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $response['success'] = true;
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>