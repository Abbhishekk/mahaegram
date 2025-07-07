<?php
session_start();
require_once "../include/connect/db.php";
require_once "../include/connect/fun.php";

header('Content-Type: application/json');
$conn = new Connect();
$conn = $conn->dbConnect();
$fun = new Fun($conn);
$action      = $_POST['action'] ?? '';
$khasara_no  = $_POST['khasara_no'] ?? '';
$ward_ids    = $_POST['ward_ids']   ?? [0];  // array of ward IDs

if (!$khasara_no) {
  echo json_encode(['success'=>false,'msg'=>'Missing khsara_no']);
  exit;
}

switch($action) {
  case 'save':
    // 1) delete existing mappings
    $stmt = $conn->prepare("DELETE FROM khasara_ward WHERE khasara_no = ?");
    $stmt->bind_param("s", $khasara_no);
    $stmt->execute();

    // 2) insert new ones
    $ins = $conn->prepare("INSERT INTO khasara_ward(khasara_no, ward_id, panchayat_code) VALUES(?,?, '$_SESSION[panchayat_code]')");
    foreach ($ward_ids as $w) {
      $ins->bind_param("si", $khasara_no, $w);
      $ins->execute();
    }
    echo json_encode(['success'=>true,'msg'=>'Saved']);
    break;

  case 'fetch':
    // fetch all ward_ids for this khasara
    $stmt = $conn->prepare("SELECT ward_id, ward_name FROM khasara_ward kw left join ward_details wd on kw.ward_id = wd.id WHERE kw.khasara_no = ? and kw.panchayat_code = $_SESSION[panchayat_code]");
    $stmt->bind_param("s",$khasara_no);
    $stmt->execute();
    $res = $stmt->get_result();
    $out = [];
    while($r = $res->fetch_assoc()) {
      $out[] = [
        "name" =>$r['ward_name'],
        "id"   =>$r['ward_id']
      ];
    }
    echo json_encode(['success'=>true,'ward_ids'=>$out]);
    break;

  default:
    echo json_encode(['success'=>false,'msg'=>'Invalid action']);
}
