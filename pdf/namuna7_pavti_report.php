<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

// Get parameters from URL
$financial_year = $_GET['financial_year'] ?? '';
$plan_name = $_GET['plan_name'] ?? '';
$bill_type = $_GET['bill_type'] ?? 'all_register';
$book_number = $_GET['book_number'] ?? '';
$pavati_number_pasun = $_GET['pavati_number_pasun'] ?? '';
$pavati_number_paryant = $_GET['pavati_number_paryant'] ?? '';
$jama_date_pasun = $_GET['jama_date_pasun'] ?? '';
$jama_date_paryant = $_GET['jama_date_paryant'] ?? '';

// Get panchayat and district info
$locationData = $fun->getLgdTableWithVillageCode($_SESSION['village_code']);
$locationData = mysqli_fetch_assoc($locationData);

// Query to fetch receipt data based on filters
$query = "SELECT * FROM `jama_pavati` WHERE `panchayat_code` = ? and `financial_year` = ? and `account_name` = ?";
$params = [$_SESSION["panchayat_code"], $financial_year, $plan_name];
$types = "sss";

if ($bill_type === 'book_number' && $book_number) {
    $query .= " AND `pustak_kramanak` = ?";
    $params[] = $book_number;
    $types .= "s";
} elseif ($bill_type === 'pavati_number_nusar') {
    if ($pavati_number_pasun && $pavati_number_paryant) {
        $query .= " AND pavati_kramanak BETWEEN ? AND ?";
        $params[] = $pavati_number_pasun;
        $params[] = $pavati_number_paryant;
        $types .= "ii";
    }
} elseif ($bill_type === 'jama_dinanknusar') {
    if ($jama_date_pasun && $jama_date_paryant) {
        $query .= " AND deposit_date BETWEEN ? AND ?";
        $params[] = $jama_date_pasun;
        $params[] = $jama_date_paryant;
        $types .= "ss";
    }
}

$query .= " ORDER BY deposit_date, pustak_kramanak";

// print_r($query);
// print_r($params);
$stmt = $db->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$receipts = $result->fetch_all(MYSQLI_ASSOC);

// Calculate total amount
$total_amount = 0;
foreach ($receipts as $receipt) {
    $total_amount += $receipt['jama_rakkam'];
}

// Prepare HTML content
$html = <<<HTML
<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <title>वसूल रजिस्टर {$financial_year}</title>
  <style>

    body {
        font-family: 'Noto Sans Devanagari', sans-serif;
        margin: 0;
        padding: 30px;
        max-width: 210mm;
        margin:auto;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      font-size: 14px;
      page-break-inside: auto;
    }
    th, td {
      border: 1px solid black;
      text-align: center;
      padding: 6px;
    }
    th {
      background-color: #f2f2f2;
    }
    caption {
      font-weight: bold;
      font-size: 16px;
      margin-bottom: 8px;
    }
    .info-table td {
      border: none;
      padding: 4px;
      text-align: left;
    }
    .header {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 18px;
    }
    .footer {
      margin-top: 20px;
      text-align: right;
      font-weight: bold;
    }
    .signature {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }

       @page {
        size: A4 portrait;
        margin: 10mm;
    }

    .text-center {
        text-align: center;
    }

    .flex {
        display: flex;
        justify-content: space-between;
    }

    .data-row td {
        font-size: 8px;
    }
  </style>
</head>
<body>
   <div class="header"><strong>नमुना क्रमांक ७ वसूल रजिस्टर सन {$financial_year}</strong></div>
   
   <div class="flex justify-between">
            <p>ग्रामपंचायत: $locationData[Village_Panchayat_Name_TLB_Name]
            </p>
            <p>तालुकाः $locationData[Development_Block_Name] </p>
            <p>जिल्हा: $locationData[District_Name] </p>
         
        </div>
    
    <table>
      <thead>
        <tr>
          <th width="5%">अ. क्र.</th>
          <th width="35%">रक्कम जमा करणाऱ्याचे नाव</th>
          <th width="15%">बुक क्रमांक</th>
          <th width="10%">पावती क्रमांक</th>
          <th width="15%">पावती दिनांक</th>
          <th width="20%">जमा रक्कम</th>
        </tr>
      </thead>
      <tbody>
HTML;

// Add receipt rows
$counter = 1;
foreach ($receipts as $receipt) {
    $html .= <<<ROW
        <tr>
          <td>{$counter}</td>
          <td>{$receipt['jama_karyana']}</td>
          <td>बुक न. {$receipt['pustak_kramanak']}</td>
          <td>{$receipt['pavati_kramanak']}</td>
          <td>{$receipt['deposit_date']}</td>
          <td>{$receipt['jama_rakkam']}</td>
        </tr>
ROW;
    $counter++;
}

// Add footer with total
$html .= <<<FOOTER
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" style="text-align: right;"><strong>एकूण</strong></td>
          <td><strong>{$total_amount}</strong></td>
        </tr>
      </tfoot>
    </table>
    
    <div class="signature">
      <div>
        <p>ग्रामसेवक / ग्रामविकास अधिकारी</p>
        <p>नाव: ___________________</p>
        <p>सही: ___________________</p>
      </div>
      <div>
        <p>सरपंच</p>
        <p>नाव: ___________________</p>
        <p>सही: ___________________</p>
      </div>
    </div>
    
    <script>
      window.onload = function() {
        window.print();
      };
    </script>
</body>
</html>
FOOTER;

echo $html;
?>