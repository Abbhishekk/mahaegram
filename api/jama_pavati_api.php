<?php
session_start();
header('Content-Type: application/json');

include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$conn = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

$response = ['success' => false, 'message' => ''];
$periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
$yearArray = $fun->getYearArray($periodsWithReasons);

// Step 1: Determine current financial year
$currentMonth = date('n'); // Numeric representation of current month (1-12)
$currentYear = date('Y');

if ($currentMonth >= 4) {
    // If April or later, financial year starts from current year
    $financialYearStart = $currentYear;
    $financialYearEnd = $currentYear + 1;
} else {
    // If Jan-March, financial year started last year
    $financialYearStart = $currentYear - 1;
    $financialYearEnd = $currentYear;
}

$currentFinancialYear = $financialYearStart . "-" . $financialYearEnd;

// Step 2: Find matching index in the array
$currentYearIndex = 0;
for ($i = 0; $i < count($yearArray); $i++) {
    if ($yearArray[$i] === $currentFinancialYear) {
        $currentYearIndex = $i;
        break;
    }
}
$financial_year = $yearArray[$currentYearIndex] ?? $currentFinancialYear;
// Get records endpoint
if (isset($_GET['get_records'])) {
    try {
        $panchayat_code = $_GET['panchayat_code'] ?? $_SESSION['panchayat_code'];

        $stmt = $conn->prepare("
            SELECT jp.*, b.bank_name 
            FROM jama_pavati jp
            LEFT JOIN bank_master b ON jp.bank_id = b.id
            WHERE jp.panchayat_code = ?
            ORDER BY jp.deposit_date DESC, jp.id DESC
        ");
        $stmt->bind_param("s", $panchayat_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $records = $result->fetch_all(MYSQLI_ASSOC);

        $response['success'] = true;
        $response['data'] = $records;

        echo json_encode($response);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}

// Insert record endpoint
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input');
    }

    // Validate required fields
    $requiredFields = [
        'plan_name',
        'deposit_date',
        'deposit_type',
        'bank_name',
        'vasul_type',
        'pustak_kramanak',
        'pavati_kramanak',
        'jama_karyana',
        'jama_rakkam'
    ];

    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Required field '$field' is missing");
        }
    }

    // Prepare default values for optional fields
    $kacchi_pavasti_pustak = $input['kacchi_pavasti_pustak'] ?? '';
    $kacchi_pavati_kramank = $input['kacchi_pavati_kramank'] ?? '';
    $check_bank_id = $input['check_bank_name'] ?? null;
    $check_date = $input['check_date'] ?? null;
    $check_bank_name = $input['check_bank_name_text'] ?? null;
    $check_number = $input['check_number'] ?? null;
    $neft_rtgs_ref_1 = $input['neft_rtgs_ref_1'] ?? null;
    $neft_rtgs_ref_2 = $input['neft_rtgs_ref_2'] ?? null;

    // Prepare the SQL statement
    $sql = "
        INSERT INTO jama_pavati (
            panchayat_code, account_name, deposit_date, deposit_type, bank_id, 
            vasul_type, pustak_kramanak, pavati_kramanak, kacchi_pavasti_pustak, 
            kacchi_pavati_kramank, jama_karyana, jama_rakkam, check_bank_id, 
            check_date, check_bank_name, check_number, neft_rtgs_ref_1, neft_rtgs_ref_2, financial_year
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind parameters - note the different type specifiers for NULL values
    $stmt->bind_param(
        "ssssisssssssdssssss",
        $_SESSION['panchayat_code'],
        $input['plan_name'],
        $input['deposit_date'],
        $input['deposit_type'],
        $input['bank_name'],
        $input['vasul_type'],
        $input['pustak_kramanak'],
        $input['pavati_kramanak'],
        $kacchi_pavasti_pustak,
        $kacchi_pavati_kramank,
        $input['jama_karyana'],
        $input['jama_rakkam'],
        $check_bank_id,
        $check_date,
        $check_bank_name,
        $check_number,
        $neft_rtgs_ref_1,
        $neft_rtgs_ref_2,
        $financial_year
    );

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'जमा पावती यशस्वीरित्या साठवली गेली आहे.';
        $response['id'] = $stmt->insert_id;
    } else {
        throw new Exception('Database insertion failed: ' . $stmt->error);
    }
} catch (Exception $e) {
    $response['message'] = 'त्रुटी: ' . $e->getMessage();
    http_response_code(400);
}

echo json_encode($response);