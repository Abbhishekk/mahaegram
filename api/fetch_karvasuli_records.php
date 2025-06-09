<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

$response = ['success' => false, 'data' => [], 'message' => ''];
$conn = new Connect();
$conn = $conn->dbConnect();
$fun = new Fun($conn);
$pdo = $conn;
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $filterType = $_POST['filter_type'] ?? 'all_register';
        $financialYear = $_POST['financial_year'] ?? '';
        $panchayatCode = $_SESSION['panchayat_code'];

        $query = "SELECT kr.*, td.financial_year 
                  FROM karvasuli_records kr
                  LEFT JOIN tax_demands td ON kr.malamatta_kramanak = td.malmatta_id
         left OUTER join malmatta_data_entry mde on mde.id =  td.malmatta_id
         LEFT outer join new_name nn1 on kr.kar_denaryache_nav = nn1.id
        LEFT outer join new_name nn2 on mde.occupant_name = nn2.id
                  WHERE mde.panchayat_code = $panchayatCode";


        // Apply filters based on selected type
        switch ($filterType) {
            case 'book_number':
                if (!empty($_POST['book_number'])) {
                    $query .= " AND kr.pustak_kramanak = '$_POST[book_number]'";
                }
                break;

            case 'vasul_dinanknusar':
                if (!empty($_POST['start_date'])) {
                    $query .= " AND kr.vasul_dinank >= '$_POST[start_date]'";
                }
                if (!empty($_POST['end_date'])) {
                    $query .= " AND kr.vasul_dinank <= '$_POST[end_date]'";
                }
                break;

            case 'pavati_number_nusar':
                if (!empty($_POST['book_number'])) {
                    $query .= " AND kr.pustak_kramanak = '$_POST[book_number]'";
                }
                if (!empty($_POST['start_receipt'])) {
                    $query .= " AND kr.pavati_kramanak >= '$_POST[start_receipt]'";
                }
                if (!empty($_POST['end_receipt'])) {
                    $query .= " AND kr.pavati_kramanak <= '$_POST[end_receipt]'";
                }
                break;

            case 'malmaat_nusar':
                if (!empty($_POST['malmatta_number'])) {
                    $query .= " AND kr.malamatta_kramanak = '$_POST[malmatta_number]'";
                }
                break;

            case 'according_to_person':
                if (!empty($_POST['person_name'])) {
                    $query .= " AND nn1.person_name LIKE '$_POST[person_name]'";
                }
                break;
        }

        // Filter by financial year if selected
        if (!empty($financialYear)) {
            $query .= " AND td.financial_year = '$financialYear'";
        }
        // echo $query;
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $response['data'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $response['success'] = true;
        $response['message'] = 'Data fetched successfully';
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>