<?php
session_start(); // Start session to store messages

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

$response = ['success' => false, 'data' => []];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $financialYear = $_POST['financial_year'] ?? '';
        $panchayatCode = $_SESSION['panchayat_code'];

        $query = "SELECT DISTINCT pustak_kramanak 
                  FROM karvasuli_records kr
         left join tax_demands td on kr.malamatta_kramanak = td.malmatta_id
         left OUTER join malmatta_data_entry mde on mde.id =  td.malmatta_id
         LEFT outer join new_name nn1 on mde.owner_name = nn1.id
        LEFT outer join new_name nn2 on mde.occupant_name = nn2.id
                  WHERE mde.panchayat_code = '$panchayatCode'";

        $params = [':panchayat_code' => $panchayatCode];

        if ($financialYear) {
            $query .= " AND td.financial_year = '$financialYear'";
            $params[':financial_year'] = $financialYear;
        }
        // echo $query;
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