<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());
// Get parameters from URL
$financial_year = $_GET['financial_year'] ?? '';
$malmatta_id = $_GET['malmatta_id'] ?? '';
$date = $_GET['date'] ?? date('Y-m-d');
$bill_type = $_GET['bill_type'] ?? 'all_bill';

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

// Get water tax data
$waterTaxData = [];
if ($malmatta_id) {
    $waterTaxData = $fun->getWaterTaxByMalmatta($malmatta_id, $financial_year);
} else {
    $waterTaxData = $fun->getAllWaterTax($financial_year);
}

// Get property owner details
$propertyDetails = [];
if ($malmatta_id) {
    $propertyDetails = $fun->getPropertyDetails($malmatta_id);
}

// Calculate due date (15 days from bill date)
$dueDate = date('Y-m-d', strtotime($date . ' +15 days'));
?>

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
  </style>
</head>
<body>

  <div class="text-center fw-bold">
    ग्रामपंचायत <?php echo $_SESSION['panchayat_name']; ?><br>
    पंचायत समिती <?php echo $_SESSION['taluka_name']; ?> जिल्हा <?php echo $_SESSION['district_name']; ?><br>
    मीटर प्रमाणे पाण्याचे देयक<br>
    <div class="text-end">दर - प्रति 1000 लिटर करिता 23 रुपये</div>
  </div>

 
    <table class="table mt-2">
      <tr>
        <td>नाव<br><b><?php echo $propertyDetails['owner_name']; ?></b></td>
        <td>मीटर क्र.<br><b><?php echo $propertyDetails['meter_no'] ?? '0'; ?></b></td>
        <td>अनु. क्र.<br><b><?php echo $propertyDetails['malmatta_no']; ?></b></td>
        <td>मोबाईल क्र.<br><b><?php echo $propertyDetails['mobile_no'] ?? ''; ?></b></td>
      </tr>
      <tr>
        <td colspan="4">पत्ता : <?php echo $propertyDetails['address'] ?? ''; ?></td>
      </tr>
    </table>


  <div class="row">
    <div class="col-6">
      <table class="table">
        <tr><td>पाणी वापर कालावधी</td><td><?php echo convertToMarathiDate($date); ?> पर्यंत</td></tr>
        <tr><td>बिल देण्याची दिनांक</td><td><?php echo convertToMarathiDate($date); ?></td></tr>
        <tr><td>अंतिम दिनांक</td><td><?php echo convertToMarathiDate($dueDate); ?></td></tr>
        <tr><td>या तारखेपर्यंत भरलेले कर</td><td>रु. <?php echo number_format($waterTaxData['total_amount'] ?? 0, 2); ?></td></tr>
        <tr><td>त्या तारखे नंतर भरल्यास</td><td>रु. <?php echo number_format(($waterTaxData['total_amount'] ?? 0) * 1.015, 2); ?></td></tr>
        <tr><td>मागील बिलाची दिनांक</td><td><?php echo convertToMarathiDate(date('Y-m-d', strtotime('-1 month', strtotime($date)))); ?></td></tr>
        <tr><td>मागील दिलेले रक्कम</td><td>रु. 0.00</td></tr>
      </table>
    </div>
    <div class="col-6">
      <table class="table">
        <?php
        $currentReading = $waterTaxData['current_reading'] ?? 0;
        $previousReading = $waterTaxData['previous_reading'] ?? 0;
        $usedReading = $currentReading - $previousReading;
        $currentBill = $usedReading * 23 / 1000; // 23 Rs per 1000 liters
        $previousDue = $waterTaxData['previous_due'] ?? 0;
        $otherCharges = $waterTaxData['other_charges'] ?? 100;
        $totalAmount = $currentBill + $previousDue + $otherCharges;
        ?>
        <tr><td>चालू रीडींग</td><td><?php echo $currentReading; ?></td></tr>
        <tr><td>मागील रीडींग</td><td><?php echo $previousReading; ?></td></tr>
        <tr><td>वापरलेले रीडींग</td><td><?php echo $usedReading; ?></td></tr>
        <tr><td>चालू बिल रक्कम</td><td>रु. <?php echo number_format($currentBill, 2); ?></td></tr>
        <tr><td>मागील थकबाकी</td><td>रु. <?php echo number_format($previousDue, 2); ?></td></tr>
        <tr><td>इतर आकार</td><td>रु. <?php echo number_format($otherCharges, 2); ?></td></tr>
        <tr class="fw-bold"><td>एकूण</td><td>रु. <?php echo number_format($totalAmount, 2); ?></td></tr>
      </table>
    </div>
  </div>

  <p class="mt-2"><b>टीप :</b><br>
    1) पाणीपुरवठा देयकानुसार नियमित भरणा करावा.<br>
    2) देयक रक्कम वेळेत न भरल्यास दर महा 1.5% व्याज आकारणी करण्यात येईल.<br>
    3) देयकाची रक्कम ३ महिन्यान न भरल्यास नळ कनेक्शन बंद करण्यात येईल.
  </p>

  <p class="text-end">सचिव<br>गट ग्रामपंचायत <?php echo $_SESSION['panchayat_name']; ?></p>

  <hr>

  <p class="fw-bold text-center">
    पहिल्या महिन्यात बिलाची रक्कम न आल्यास थकबाकी रक्कमेत तेंडरची रक्कम जोडण्यात येईल
  </p>

  <table class="table">
    <tr>
      <td>पाणी वापर कालावधी</td><td><?php echo convertToMarathiDate($date); ?> पर्यंत</td>
      <td>मागील बिलाची दिनांक</td><td><?php echo convertToMarathiDate(date('Y-m-d', strtotime('-1 month', strtotime($date)))); ?></td>
    </tr>
    <tr>
      <td>बिल देण्याची दिनांक</td><td><?php echo convertToMarathiDate($date); ?></td>
      <td>अंतिम दिनांक</td><td><?php echo convertToMarathiDate($dueDate); ?></td>
    </tr>
  </table>

  <?php if ($bill_type === 'all_bill'): ?>
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
        <?php 
        $allWaterTaxData = $fun->getAllWaterTax($financial_year);
        $counter = 1;
        foreach ($allWaterTaxData as $data): 
          $currentReading = $data['current_reading'] ?? 0;
          $previousReading = $data['previous_reading'] ?? 0;
          $usedReading = $currentReading - $previousReading;
          $currentBill = $usedReading * 23 / 1000;
          $previousDue = $data['previous_due'] ?? 0;
          $otherCharges = $data['other_charges'] ?? 100;
          $totalAmount = $currentBill + $previousDue + $otherCharges;
        ?>
          <tr>
            <td><?php echo $counter++; ?></td>
            <td><?php echo $data['owner_name']; ?></td>
            <td><?php echo $data['meter_no'] ?? '0'; ?></td>
            <td><?php echo $usedReading; ?></td>
            <td>रु. <?php echo number_format($currentBill, 2); ?></td>
            <td>रु. <?php echo number_format($previousDue, 2); ?></td>
            <td><?php echo number_format($otherCharges, 2); ?></td>
            <td>रु. <?php echo number_format($totalAmount, 2); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p>बिल प्राप्त दिनांक : _____________</p>
  <p class="text-end">सचिव<br>गट ग्रामपंचायत <?php echo $_SESSION['panchayat_name']; ?></p>

</body>
</html>