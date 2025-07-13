<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

// Get parameters
$financial_year = $_POST['financial_year'] ?? '';
$malmatta_id = $_POST['malmatta_id'] ?? '';
$date = $_POST['date'] ?? date('Y-m-d');
$bill_type = $_POST['bill_type'] ?? 'all_bill';

// Handle signature upload
$signatureHtml = '';
if (isset($_FILES['sarpanch_signature']) && $_FILES['sarpanch_signature']['error'] == UPLOAD_ERR_OK) {
    $signatureData = base64_encode(file_get_contents($_FILES['sarpanch_signature']['tmp_name']));
    $signatureHtml = '<img src="data:image/png;base64,'.$signatureData.'" style="max-height: 80px;" alt="Sarpanch Signature">';
}

// Get water tax data
$waterTaxData = [];
if ($malmatta_id) {
    $data = $fun->getWaterTaxByMalmatta($malmatta_id, $financial_year);
    $waterTaxData = [$data];
} else {
    $waterTaxData = $fun->getAllWaterTax($financial_year);
}

// Function to convert date to Marathi format
function convertToMarathiDate($date) {
    $months = [
        '01' => 'जानेवारी', '02' => 'फेब्रुवारी', '03' => 'मार्च',
        '04' => 'एप्रिल', '05' => 'मे', '06' => 'जून',
        '07' => 'जुलै', '08' => 'ऑगस्ट', '09' => 'सप्टेंबर',
        '10' => 'ऑक्टोबर', '11' => 'नोव्हेंबर', '12' => 'डिसेंबर'
    ];
    
    $dateParts = explode('-', $date);
    $day = $dateParts[2];
    $month = $months[$dateParts[1]];
    $year = $dateParts[0];
    
    return "$day $month $year";
}
$date = convertToMarathiDate($date);
// Generate HTML
$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Namuna 9 - Gram Panchayat</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    table {
      width: 100%;
      background-color: #fff;
    }

    table, th, td {
      border: 1px solid #333;
      border-collapse: collapse;
      text-align: center;
    }

    th {
      background-color: #e0e0e0;
    }

    th, td {
      padding: 6px;
      font-size: 14px;
    }

    h1, h2 {
      margin: 10px 0;
      text-align: center;
    }

    .footer {
      margin-top: 30px;
      display: flex;
      justify-content: space-between;
    }

    .signature {
      text-align: center;
      margin-top: 50px;
    }
  </style>
</head>
<body>

  <h2>नमुना क्रमांक 9</h2>
  <h1>पाणीपट्टी मागणीचे बिल</h1>

  <div style="text-align: center; margin-bottom: 20px;">
    <strong>ग्राम पंचायत:</strong> {$_SESSION['panchayat_name']}
    &nbsp;&nbsp;&nbsp;
    <strong>जिल्हा:</strong> {$_SESSION['district_name']}
    &nbsp;&nbsp;&nbsp;
    <strong>दिनांक:</strong> {$date}
  </div>

  <table>
    <thead>
      <tr>
        <th rowspan="2">क्रमांक</th>
        <th rowspan="2">मालमत्ता क्रमांक</th>
        <th rowspan="2" colspan="3">नाव</th>
        <th rowspan="2">बिल क्रमांक</th>
        <th rowspan="2">मागील थकबाकी रक्कम</th>
        <th colspan="25"><h3 style="margin: 0;">मीटर रीडिंग</h3></th>
      </tr>
      <tr>
        <th>एप्रिल</th>
        <th>जमा</th>
        <th>मे</th>
        <th>जमा</th>
        <th>जून</th>
        <th>जमा</th>
        <th>जुलै</th>
        <th>जमा</th>
        <th>ऑगस्ट</th>
        <th>जमा</th>
        <th>सप्टेंबर</th>
        <th>जमा</th>
        <th>ऑक्टोबर</th>
        <th>जमा</th>
        <th>नोव्हेंबर</th>
        <th>जमा</th>
        <th>डिसेंबर</th>
        <th>जमा</th>
        <th>जानेवारी</th>
        <th>जमा</th>
        <th>फेब्रुवारी</th>
        <th>जमा</th>
        <th>मार्च</th>
        <th>जमा</th>
        <th>एकूण</th>
      </tr>
    </thead>
    <tbody>
HTML;

// Add data rows
$counter = 1;
foreach ($waterTaxData as $data) {
    // Ensure all readings are set, defaulting to empty string if not available
    $data = array_merge([], $data);
    $data['previous_due'] = $data['previous_due'] ?? '';
    $html .= <<<HTML
      <tr>
        <td>{$counter}</td>
        <td>{$data['malmatta_no']}</td>
        <td colspan="3">{$data['owner_name']}</td>
        <td>BILL-{$data['malmatta_no']}-{$financial_year}</td>
        <td>{$data['previous_due'] }</td>
        <td>{$data['april_reading']}</td>
        <td></td>
        <td>{$data['may_reading']}</td>
        <td></td>
        <td>{$data['jun_reading']}</td>
        <td></td>
        <td>{$data['jul_reading']}</td>
        <td></td>
        <td>{$data['aug_reading']}</td>
        <td></td>
        <td>{$data['sep_reading']}</td>
        <td></td>
        <td>{$data['oct_reading']}</td>
        <td></td>
        <td>{$data['nov_reading']}</td>
        <td></td>
        <td>{$data['dec_reading']}</td>
        <td></td>
        <td>{$data['jan_reading']}</td>
        <td></td>
        <td>{$data['feb_reading']}</td>
        <td></td>
        <td>{$data['mar_reading']}</td>
        <td></td>
        <td>{$data['total_amount']}</td>
      </tr>
HTML;
    $counter++;
}

$html .= <<<HTML
    </tbody>
  </table>

  <div class="footer">
    <div class="signature">
      <p>ग्रामसेवक / ग्रामविकास अधिकारी</p>
      <p>नाव: ___________________</p>
    </div>
    <div class="signature">
      <p>सरपंच</p>
      {$signatureHtml}
      <p>नाव: ___________________</p>
    </div>
  </div>

</body>
</html>
HTML;

echo $html;