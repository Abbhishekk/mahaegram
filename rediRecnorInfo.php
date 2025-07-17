<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "रेडीरेकनर दर माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $readyRecInfo = $fun->getReadyrecInfo();
    $readyRecParts = $fun->getReadyrecParts();
$financialYears = $fun->getFinancialYears();
$disabled = "";
 $periodsWithReasons2 = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
 if(mysqli_num_rows($periodsWithReasons2) > 0){
     $yearArray = $fun->getYearArray($periodsWithReasons2);
     $disabled = "";
 }else {
        $yearArray = [];
        $_SESSION['message'] = "नमुना नंबर 8 कालावधी नोंदवलेली नाही.";
        $_SESSION['message_type'] = "warning";
        $disabled = "disabled";
 }
$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);
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
                        <h1 class="h3 mb-0 text-gray-800">रेडीरेकनर दर माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">रेडीरेकनर दर माहिती</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">रेडीरेकनर दर व्यवस्थापन</h6>
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
                <form method="post" action="api/readyRec.php">
                    <div class="row g-3">
                        <!-- आर्थिक वर्ष -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select border-primary" name="financialYear" id="financialYear" required>
                                    <?php
                                    if(count($yearArray) > 0){
                                        foreach($yearArray as $year){
                                            echo '<option value="'.$year.'">'.$year.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="financialYear">आर्थिक वर्ष <span class="text-danger">*</span></label>
                                <input type="number" value="" class="form-control d-none" name="update" id="update">
                            </div>
                        </div>

                        <!-- महसूल गावाचे नाव -->
                        <div class="col-md-4">
                            <div class="form-floating p-3">
                                <select class="form-select border-primary select2 select2-single-placeholder" name="village_name" id="village_name" required>
                                    <option value="" >--निवडा--</option>
                                    <?php
                                    if(mysqli_num_rows($lgdVillages) > 0){
                                        while($village = mysqli_fetch_assoc($lgdVillages)){
                                            echo "<option value='".$village['Village_Code']."'>".$village['Village_Name']."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="village_name"> गावाचे नाव <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <!-- रेडीरेकनर प्रमाणे भाग/उपविभाग -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select border-primary" name="readyrec_part" id="readyrec_part" required>
                                    <option value="" selected>--निवडा--</option>
                                    <?php
                                    if(mysqli_num_rows($readyRecParts) > 0){
                                        while($readyRecPart = mysqli_fetch_assoc($readyRecParts)){
                                            echo "<option value='".$readyRecPart['readyrec_part']."'>".$readyRecPart['readyrec_part']."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="readyrec_part">रेडीरेकनर प्रमाणे भाग/उपविभाग <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <!-- जमिनीचा प्रकार -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="land_type" id="land_type" 
                                       placeholder="जमिनीचा प्रकार">
                                <label for="land_type">जमिनीचा प्रकार</label>
                            </div>
                        </div>

                        <!-- रेडियो बटणे -->
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recording" id="recording1" 
                                       value="जमिनीचे वार्षिक मूल्य दर नोंद करणे">
                                <label class="form-check-label" for="recording1">जमिनीचे वार्षिक मूल्य दर नोंद करणे</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recording" id="recording2" 
                                       value="इमारतीचे वार्षिक मूल्य दर नोंद करणे">
                                <label class="form-check-label" for="recording2">इमारतीचे वार्षिक मूल्य दर नोंद करणे</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recording" id="recording3" 
                                       value="ऑफिस वार्षिक मूल्य दर नोंद करणे">
                                <label class="form-check-label" for="recording3">ऑफिस वार्षिक मूल्य दर नोंद करणे</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recording" id="recording4" 
                                       value="दुकान वार्षिक मूल्य दर नोंद करणे">
                                <label class="form-check-label" for="recording4">दुकान वार्षिक मूल्य दर नोंद करणे</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recording" id="recording5" 
                                       value="औद्योगिक वार्षिक मूल्य दर नोंद करणे">
                                <label class="form-check-label" for="recording5">औद्योगिक वार्षिक मूल्य दर नोंद करणे</label>
                            </div>
                        </div>

                        <!-- वार्षिक मूल्य दर -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="yearly_tax" id="yearly_tax" 
                                       placeholder="वार्षिक मूल्य दर" required>
                                <label for="yearly_tax">वार्षिक मूल्य दर <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- टीप -->
                    <div class="alert alert-warning mt-4 text-center">
                        <strong>टीप:</strong> नमुना क्रमांक ८ स्वयं:निर्मित (Auto Generate) करण्याकरिता रेडीरेकनर दर फक्त एकदाच नोंद करता येणार आहे, तरी ग्रामपंचायतीने ठरवलेला अचूक दर नोंद करण्यात यावा.
                    </div>

                    <!-- बटणे -->
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <button type="submit" name="add" class="btn btn-primary px-4" <?= $disabled ?? "" ?>>
                            <i class="fas fa-save me-2"></i>साठवणे
                        </button>
                        <button type="reset" class="btn btn-outline-danger px-4">
                            <i class="fas fa-times me-2"></i>रद्द करणे
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">रेडीरेकनर दर यादी</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>अ.क्र.</th>
                            <th>आर्थिक वर्ष</th>
                            <th>गावाचे नाव</th>
                            <th>रेडीरेकनर प्रमाणे भाग/उपविभाग</th>
                            <th>जमिनीचा प्रकार</th>
                            <th>वार्षिक मूल्य दर</th>
                            <th>बदल</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(mysqli_num_rows($readyRecInfo) > 0){
                            $i = 1;
                            while($readyRec = mysqli_fetch_assoc($readyRecInfo)){
                        ?>
                        <tr>
                            <td><a href="#"><?php echo $i; ?></a></td>
                            <td><?php echo $readyRec['financial_years']; ?></td>
                            <td><?php echo $readyRec['Village_Name']; ?></td>
                            <td><?php echo $readyRec['readyrec_type']; ?></td>
                            <td><?php echo $readyRec['land_type']; ?></td>
                            <td><?php echo $readyRec['yearly_tax']; ?></td>
                            <td>
                                <a href="#" class="text-primary" 
                                   onclick="filldata('<?php echo $readyRec['rid']; ?>', '<?php echo $readyRec['financial_years']; ?>', '<?php echo $readyRec['revenue_village']; ?>', '<?php echo $readyRec['readyrec_type']; ?>', '<?php echo $readyRec['land_type']; ?>', '<?php echo $readyRec['yearly_tax']; ?>', '<?php echo $readyRec['recordings']; ?>')">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                                $i++;
                            }
                        }else{
                            echo "<tr><td colspan='7' class='text-center'>No data found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
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
    function filldata(id, financialYear, revenueVillage, readyrecPart, landType, yearlyTax, recordings) {
        document.getElementById('update').value = id;

        document.getElementById('financialYear').value = financialYear;
        console.log(financialYear);
        
        document.getElementById('village_name').value = revenueVillage;
        console.log(revenueVillage);
        
        document.getElementById('readyrec_part').value = readyrecPart;
        document.getElementById('land_type').value = landType;
        document.getElementById('yearly_tax').value = yearlyTax;

        if (recordings) {
            const radioButton = document.querySelector(`input[name="recording"][value="${recordings}"]`);
            if (radioButton) {
                radioButton.checked = true;
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const decision_date = document.getElementById('decision_date');
        const redirecSelect = document.getElementById('readyrec_part');
        const land_type = document.getElementById('land_type');

        redirecSelect.addEventListener('change', function() {
            const selectedValue = redirecSelect.value;
            land_type.value = selectedValue;
            // land_type.setAttribute('readonly', true);
        });
        decision_date.value = new Date().toISOString().split('T')[0];



    });
    </script>
      <script>
$(document).ready(function () {
  $('select.select2').select2({
    placeholder: "--निवडा--",
    allowClear: true,
    dropdownAutoWidth: true,
    width: 'resolve'
  });
});
 </script>
</body>

</html>