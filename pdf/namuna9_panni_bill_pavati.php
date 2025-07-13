<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());

// Get parameters from URL
$financial_year = $_POST['financial_year'] ?? '';
$malmatta_id = $_POST['malmatta_id'] ?? '';
$date = $_POST['date'] ?? date('Y-m-d');
$bill_type = $_POST['bill_type'] ?? 'all_bill';
// print_r($_POST);
$signaturePath = '';
if (isset($_FILES['sarpanch_signature'])) {
    $targetDir = "../uploads/signatures/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = uniqid() . '_' . basename($_FILES['sarpanch_signature']['name']);
    $targetFile = $targetDir . $fileName;
    
    if (move_uploaded_file($_FILES['sarpanch_signature']['tmp_name'], $targetFile)) {
        $signaturePath = $targetFile;
    }
}


// Convert date to Marathi format
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

// Get current month
$currentMonth = date('m');
$monthNames = [
    '01' => 'जानेवारी', '02' => 'फेब्रुवारी', '03' => 'मार्च',
    '04' => 'एप्रिल', '05' => 'मे', '06' => 'जून',
    '07' => 'जुलै', '08' => 'ऑगस्ट', '09' => 'सप्टेंबर',
    '10' => 'ऑक्टोबर', '11' => 'नोव्हेंबर', '12' => 'डिसेंबर'
];
$signatureHtml = '';
if (!empty($signaturePath)) {
    $signatureData = base64_encode(file_get_contents($signaturePath));
    $signatureHtml = '<img src="data:image/png;base64,'.$signatureData.'" style="max-height: 80px;" alt="Sarpanch Signature">';
    // Delete the temporary file
    unlink($signaturePath);
}


// Get water tax data
$waterTaxData = [];
if ($malmatta_id) {
    $data = $fun->getWaterTaxByMalmatta($malmatta_id, $financial_year);
    if(empty($data)) {
        echo "<h3 class='text-center'>पाणी वापर बिल साठी कोणतेही डेटा उपलब्ध नाही.</h3>";
        exit;
    }
    $waterTaxData = [$data]; // Convert to array for consistency
} else {
    $waterTaxData = $fun->getAllWaterTax($financial_year);
}
// print_r($waterTaxData);
// If no data found, show message
if (empty($waterTaxData)) {
    echo "<h3 class='text-center'>पाणी वापर बिल साठी कोणतेही डेटा उपलब्ध नाही.</h3>";
    exit;
}

// Calculate due date (15 days from bill date)
$dueDate = date('Y-m-d', strtotime($date . ' +15 days'));

// Initialize document totals
$document_totals = [
    "current_reading" => 0,
    "previous_reading" => 0,
    "used_reading" => 0,
    "current_bill" => 0,
    "previous_due" => 0,
    "other_charges" => 0,
    "total_amount" => 0
];

// Generate HTML for each bill
$html = "";
foreach ($waterTaxData as $data) {
    // Get property details
    $propertyDetails = [
        'owner_name' => $data['owner_name'],
        'meter_no' => $data['meter_no'] ?? '',
        'malmatta_no' => $data['malmatta_no'],
        'mobile_no' => '', // Add if available
        'address' => $data['address'] ?? ''
    ];
    
    // Get current month reading
    $currentMonthField = strtolower(date('M', strtotime($date))) . '_reading';
    $currentReading = $data[$currentMonthField] ?? 0;
    
    // Get previous month reading
    $prevMonth = date('m', strtotime('-1 month', strtotime($date)));
    $prevMonthField = strtolower(date('M', strtotime("2025-$prevMonth-01"))) . '_reading';
    $previousReading = $data[$prevMonthField] ?? 0;
    
    // Calculate values
    $usedReading = (int)$currentReading - (int)$previousReading;
    $currentBill = $usedReading * 23 / 1000; // 23 Rs per 1000 liters
    $previousDue = $data['total_amount'] - $currentBill; // Assuming total_amount includes previous due
    $otherCharges = $data['ittar_aakar'] ?? 0;
    $totalAmount = (int)($currentBill) + (int)($previousDue) + (int)($otherCharges);
    
    // Format values for display
    $marathiDate = convertToMarathiDate($date);
    $marathiDueDate = convertToMarathiDate($dueDate);
    $prevBillDate = convertToMarathiDate(date('Y-m-d', strtotime('-1 month', strtotime($date))));
    $formattedTotalAmount = number_format($totalAmount, 2);
    $formattedLateAmount = number_format($totalAmount * 1.015, 2);
    $formattedCurrentBill = number_format($currentBill, 2);
    $formattedPreviousDue = number_format($previousDue, 2);
    $formattedOtherCharges = number_format((float)$otherCharges, 2);
    
    $currentMonthName = $monthNames[date('m', strtotime($date))];
    $prevMonthName = $monthNames[$prevMonth];
    
    // Update document totals
    $document_totals['current_reading'] += (int)$currentReading;
    $document_totals['previous_reading'] += $previousReading;
    $document_totals['used_reading'] += $usedReading;
    $document_totals['current_bill'] += $currentBill;
    $document_totals['previous_due'] += $previousDue;
    $document_totals['other_charges'] += (int)$otherCharges;
    $document_totals['total_amount'] += $totalAmount;
    
    $html .= <<<HTML
<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <title>पाणी वापर बिल</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-size: 14px;
      padding: 20px;
    }
    table, th, td {
      border: 1px solid black !important;
    }
    .borderless td, .borderless th {
      border: none !important;
    }
    @page {
      size: A4;
      margin: 10mm;
    }
    .receipt-box { border: 2px solid black; padding: 20px; margin: 10px auto; }
    .dashed-border { border-top: 2px dashed black; margin-top: 20px; }
    table { page-break-inside: avoid; }
    .month-reading { width: 8%; text-align: center; }
  </style>
</head>
<body>
  <div class="receipt-box">
    <div class="text-center fw-bold">
      ग्रामपंचायत {$_SESSION['panchayat_name']}<br>
      पंचायत समिती {$_SESSION['block_name']} जिल्हा {$_SESSION['district_name']}<br>
      मीटर प्रमाणे पाण्याचे देयक<br>
      <div class="text-end">दर - प्रति 1000 लिटर करिता 23 रुपये</div>
    </div>

    <table class="table mt-2">
      <tr>
        <td>नाव<br><b>{$propertyDetails['owner_name']}</b></td>
        <td>मीटर क्र.<br><b>{$propertyDetails['meter_no']}</b></td>
        <td>अनु. क्र.<br><b>{$propertyDetails['malmatta_no']}</b></td>
        <td>मोबाईल क्र.<br><b>{$propertyDetails['mobile_no']}</b></td>
      </tr>
      <tr>
        <td colspan="4">पत्ता : {$propertyDetails['address']}</td>
      </tr>
    </table>

    <div class="row">
      <div class="col-6">
        <table class="table">
          <tr><td>पाणी वापर कालावधी</td><td>{$marathiDate} पर्यंत</td></tr>
          <tr><td>बिल देण्याची दिनांक</td><td>{$marathiDate}</td></tr>
          <tr><td>अंतिम दिनांक</td><td>{$marathiDueDate}</td></tr>
          <tr><td>या तारखेपर्यंत भरलेले कर</td><td>रु. {$formattedTotalAmount}</td></tr>
          <tr><td>त्या तारखे नंतर भरल्यास</td><td>रु. {$formattedLateAmount}</td></tr>
          <tr><td>मागील बिलाची दिनांक</td><td>{$prevBillDate}</td></tr>
          <tr><td>मागील दिलेले रक्कम</td><td>रु. 0.00</td></tr>
        </table>
      </div>
      <div class="col-6">
        <table class="table">
          <tr><td>चालू रीडींग ({$currentMonthName})</td><td>{$currentReading}</td></tr>
          <tr><td>मागील रीडींग ({$prevMonthName})</td><td>{$previousReading}</td></tr>
          <tr><td>वापरलेले रीडींग</td><td>{$usedReading}</td></tr>
          <tr><td>चालू बिल रक्कम</td><td>रु. {$formattedCurrentBill}</td></tr>
          <tr><td>मागील थकबाकी</td><td>रु. {$formattedPreviousDue}</td></tr>
          <tr><td>इतर आकार</td><td>रु. {$formattedOtherCharges}</td></tr>
          <tr class="fw-bold"><td>एकूण</td><td>रु. {$formattedTotalAmount}</td></tr>
        </table>
      </div>
    </div>

    <!-- Monthly Readings Table -->
    <table class="table mt-3">
      <thead>
        <tr>
          <th colspan="12" class="text-center">मासिक रीडिंग</th>
        </tr>
        <tr>
          <th class="month-reading">जाने</th>
          <th class="month-reading">फेब्रु</th>
          <th class="month-reading">मार्च</th>
          <th class="month-reading">एप्रिल</th>
          <th class="month-reading">मे</th>
          <th class="month-reading">जून</th>
          <th class="month-reading">जुलै</th>
          <th class="month-reading">ऑग</th>
          <th class="month-reading">सप्टें</th>
          <th class="month-reading">ऑक्टो</th>
          <th class="month-reading">नोव्हें</th>
          <th class="month-reading">डिसें</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="month-reading">{$data['jan_reading']}</td>
          <td class="month-reading">{$data['feb_reading']}</td>
          <td class="month-reading">{$data['mar_reading']}</td>
          <td class="month-reading">{$data['april_reading']}</td>
          <td class="month-reading">{$data['may_reading']}</td>
          <td class="month-reading">{$data['jun_reading']}</td>
          <td class="month-reading">{$data['jul_reading']}</td>
          <td class="month-reading">{$data['aug_reading']}</td>
          <td class="month-reading">{$data['sep_reading']}</td>
          <td class="month-reading">{$data['oct_reading']}</td>
          <td class="month-reading">{$data['nov_reading']}</td>
          <td class="month-reading">{$data['dec_reading']}</td>
        </tr>
      </tbody>
    </table>

    <p class="mt-2"><b>टीप :</b><br>
      1) पाणीपुरवठा देयकानुसार नियमित भरणा करावा.<br>
      2) देयक रक्कम वेळेत न भरल्यास दर महा 1.5% व्याज आकारणी करण्यात येईल.<br>
      3) देयकाची रक्कम ३ महिन्यान न भरल्यास नळ कनेक्शन बंद करण्यात येईल.
    </p>
    <div class="text-end">
      <p class="fw-bold">सरपंच सही</p>
      {$signatureHtml}
    </div>
    <p class="text-end">सचिव<br>गट ग्रामपंचायत {$_SESSION['panchayat_name']}</p>

    <div class="dashed-border"></div>
  </div>
  <div style="page-break-after: always;"></div>
HTML;
}

// Add summary table for all bills
if ($bill_type === 'all_bill' && count($waterTaxData) > 1) {
    // Format totals for display
    $total_current_bill = number_format($document_totals['current_bill'], 2);
    $total_previous_due = number_format($document_totals['previous_due'], 2);
    $total_other_charges = number_format($document_totals['other_charges'], 2);
    $total_amount = number_format($document_totals['total_amount'], 2);
    
    $html .= <<<HTML
<div class="receipt-box">
  <h4 class="text-center fw-bold">पाणी वापर बिल सारांश</h4>
  
  <table class="table text-center">
    <thead>
      <tr>
        <th>अनु.क्र.</th>
        <th>नाव</th>
        <th>मीटर क्र.</th>
        <th>वापरलेले रीडींग</th>
        <th>चालू बिल रक्कम</th>
        <th>मागील थकबाकी</th>
        <th>इतर आकार</th>
        <th>एकूण</th>
      </tr>
    </thead>
    <tbody>
HTML;

    $counter = 1;
    foreach ($waterTaxData as $data) {
        $propertyDetails = [
            'owner_name' => $data['owner_name'],
            'meter_no' => $data['meter_no'] ?? '',
            'malmatta_no' => $data['malmatta_no']
        ];
        
        $currentMonthField = strtolower(date('M', strtotime($date))) . '_reading';
        $currentReading = $data[$currentMonthField] ?? 0;
        
        $prevMonth = date('m', strtotime('-1 month', strtotime($date)));
        $prevMonthField = strtolower(date('M', strtotime("2025-$prevMonth-01"))) . '_reading';
        $previousReading = $data[$prevMonthField] ?? 0;
        
        $usedReading = (int)$currentReading - (int)$previousReading;
        $currentBill = $usedReading * 23 / 1000;
        $previousDue = $data['total_amount'] - $currentBill;
        $otherCharges = $data['ittar_aakar'] ?? 0;
        $totalAmount = (int)$currentBill + (int)$previousDue + (int)$otherCharges;
        
        // Format values for display
        $formattedCurrentBill = number_format($currentBill, 2);
        $formattedPreviousDue = number_format($previousDue, 2);
        $formattedOtherCharges = number_format((float)$otherCharges, 2);
        $formattedTotalAmount = number_format($totalAmount, 2);
        
        $html .= <<<HTML
      <tr>
        <td>{$counter}</td>
        <td>{$propertyDetails['owner_name']}</td>
        <td>{$propertyDetails['meter_no']}</td>
        <td>{$usedReading}</td>
        <td>रु. {$formattedCurrentBill}</td>
        <td>रु. {$formattedPreviousDue}</td>
        <td>रु. {$formattedOtherCharges}</td>
        <td>रु. {$formattedTotalAmount}</td>
      </tr>
HTML;
        $counter++;
    }

    $html .= <<<HTML
      <tr class="fw-bold">
        <td colspan="3">एकूण</td>
        <td>{$document_totals['used_reading']}</td>
        <td>रु. {$total_current_bill}</td>
        <td>रु. {$total_previous_due}</td>
        <td>रु. {$total_other_charges}</td>
        <td>रु. {$total_amount}</td>
      </tr>
    </tbody>
  </table>
  
  <p class="text-end">सचिव<br>गट ग्रामपंचायत {$_SESSION['panchayat_name']}</p>
</div>
HTML;
}

$html .= <<<HTML
<script>
  window.onload = function() {
    window.print();
  };
</script>
</body>
</html>
HTML;

echo $html;