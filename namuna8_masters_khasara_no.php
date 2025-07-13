<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "Dashboard";
?>
<?php include('include/header.php'); ?>
<?php
$wards = $fun->getWard($_SESSION['district_code']);
$khasaraWardList = $fun->getKhasaraWardMappings($_SESSION['district_code']);

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna8';
        $subpage = 'wardMaster';
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
                include('include/sidebar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">वार्ड माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वार्ड माहिती</li>
                        </ol>
                    </div>

                   <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">खसारा क्रमांक - वॉर्ड नोंद</h6>
            </div>
            <div class="card-body">
                <?php
                if (isset($_SESSION['message'])) {
                    $message = $_SESSION['message'];
                    $message_type = $_SESSION['message_type'];
                    echo "<div class='alert alert-$message_type'>$message</div>";
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                }
                ?>
                <form id="khasaraWardForm">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="khasara_no" name="khasara_no" 
                                       class="form-control border-primary" placeholder="खसारा क्रमांक">
                                <label for="khasara_no">खसारा क्रमांक</label>
                            </div>
                        </div>
                        <div class="col-md-8 d-none">
                            <div class="form-floating">
                                <select id="ward_ids" name="ward_ids[]" 
                                        class="form-select border-primary select2-multiple" multiple>
                                    <?php
                                    $allWards = $fun->getWard($_SESSION['district_code']);
                                    while ($w = mysqli_fetch_assoc($allWards)) {
                                        echo "<option value='{$w['id']}'>{$w['ward_no']} - {$w['ward_name']}</option>";
                                    }
                                    ?>
                                </select>
                                <label for="ward_ids">वार्ड निवडा</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="button" id="saveBtn" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>साठवणे
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">खसारा क्रमांक - वॉर्ड नोंदी</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>अ.क्र.</th>
                            <th>खसारा क्रमांक</th>
                            <!--<th>वॉर्ड क्रमांक</th>-->
                            <!--<th>वॉर्ड नाव</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($khasaraWardList && mysqli_num_rows($khasaraWardList) > 0) {
                            $i = 1;
                            $currentKhasara = '';
                            $rowspanMap = [];
                           
                            // Group ward entries by khasara_no
                            while ($row = mysqli_fetch_assoc($khasaraWardList)) {
                                $rowspanMap[$row['khasara_no']][] = $row;
                            }

                            // Display grouped data
                            foreach ($rowspanMap as $khasara_no => $wards) {
                                $first = true;
                                foreach ($wards as $ward) {
                                    echo "<tr>";
                                    if ($first) {
                                        echo "<td rowspan='" . count($wards) . "'>$i</td>";
                                        echo "<td rowspan='" . count($wards) . "'>$khasara_no</td>";
                                        $first = false;
                                        $i++;
                                    }
                                    // echo "<td>{$ward['ward_no']}</td><td>{$ward['ward_name']}</td></tr>";
                                }
                            }
                        } else {
                            //  print_r($khasaraWardList);
                            echo "<tr><td colspan='4' class='text-center'>कोणतीही नोंद उपलब्ध नाही.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <?php include('include/footer.php'); ?>
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include('include/scripts.php'); ?>
    <script>
        function filldata(ward_no, ward_name) {
            document.getElementById('ward_no').value = ward_no;
            document.getElementById('ward_name').value = ward_name;
        }
    </script>
    <script>
  const khasaraInput = document.getElementById('khasara_no');
  const wardSelect   = $('#ward_ids'); // assuming Select2
  
  // when you blur or change khasara_no, fetch existing wards
  khasaraInput.addEventListener('blur', () => {
    const kn = khasaraInput.value.trim();
    if (!kn) return;
    $.post('api/khasara_ward.php', {action:'fetch', khasara_no:kn}, resp => {
      if (resp.success) {
        wardSelect.val(resp.ward_ids).trigger('change');
      } else {
        wardSelect.val([]).trigger('change');
      }
    }, 'json');
  });

  // save on button click
  document.getElementById('saveBtn').addEventListener('click', () => {
    const kn = khasaraInput.value.trim();
    const wids = wardSelect.val() || [];
    if (!kn) { alert('कृपया खसारा क्रमांक भरा'); return; }
    $.post('api/khasara_ward.php',
      { action:'save', khasara_no:kn, ward_ids:wids },
      resp => {
        alert(resp.msg);
        window.location.href = "Form_Malmatta_N8.php"; // reload to see changes
      }, 'json');
  });
</script>

</body>

</html>