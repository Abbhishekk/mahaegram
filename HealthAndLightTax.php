<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "आरोग्य व दिवाबत्ती कर माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $durationReason = $fun->getDurationReason();
    $periods = $fun->getPeriodDetailsLastValue($_SESSION['district_code']);
    $taxInfosArea = $fun->getTaxInfo($_SESSION['district_code']);  
    if(mysqli_num_rows($taxInfosArea) == 0){
        $ranges = ["1 to 300", "301 to 700", "701 to 9999"];
    }else{
        $ranges = [];
        while($row = mysqli_fetch_assoc($taxInfosArea)){
            $ranges[] = $row['area_range'];
        }
        //  print_r($ranges);
    }
     $taxInfosAarogya = $fun->getTaxInfo($_SESSION['district_code']);
    $taxInfosDivabatti = $fun->getTaxInfo($_SESSION['district_code']);
    $taxInfosSafai = $fun->getTaxInfo($_SESSION['district_code']);
    if(!isset($periods['total_period']) || $periods['total_period'] == null){
        $_SESSION['message'] = "कालावधी उपलब्ध नाही. कृपया कालावधी तयार करा.";
        $_SESSION['message_type'] = "danger";
     
    }
    $isTharavExists = $fun->isTharavExists($periods['total_period'] ?? null);
    $getTharavByPeriod = $fun->getTharavByPeriod($periods['total_period'] ?? null);
    if (mysqli_num_rows($getTharavByPeriod) > 0) {
        $row = mysqli_fetch_assoc($getTharavByPeriod);
        
        $isTharavExists = true;
    } else {
       
        $isTharavExists = false;
        $row = null;
    }
    
    // echo $isTharavExists;
    // print_r($row);
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
                        <h1 class="h3 mb-0 text-gray-800">आरोग्य व दिवाबत्ती कर माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">आरोग्य व दिवाबत्ती कर माहिती</li>
                        </ol>
                    </div>

                   <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">आरोग्य व कर व्यवस्थापन</h6>
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
                <form method="post" action="api/healthAndTax.php">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="period" id="period" 
                                       value="<?php echo $periods['total_period'] ?? null; ?>" readonly>
                                <label for="period">नमुना ८ कालावधी करिता <span class="text-danger">*</span></label>
                                <input type="number" value="" class="form-control d-none" name="update" id="update">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control border-primary" name="decisionDate" 
                                           id="decisionDate" required>
                                </div>
                                <label for="decisionDate"> <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="descisionNo" 
                                       value="<?php echo ($row == null? "" : $row['tharav_no'])?>"
                                       <?php echo ($isTharavExists)?"disabled":"" ?> id="descisionNo">
                                <label for="descisionNo">ठराव क्रमांक <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-12 my-3"></div>

                        <div class="col-md-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="healthTax" name="healthTax" 
                                       value="healthTax" <?php echo ($isTharavExists)?"disabled":"" ?>>
                                <label class="form-check-label" for="healthTax">आरोग्य कर नसल्यास</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="lightTax" name="lightTax" 
                                       value="lightTax" <?php echo ($isTharavExists)?"disabled":"" ?>>
                                <label class="form-check-label" for="lightTax">दिवाबत्ती कर नसल्यास</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="safaiTax" name="safaiTax" 
                                       value="safaiTax" <?php echo ($isTharavExists)?"disabled":"" ?>>
                                <label class="form-check-label" for="safaiTax">सफाई कर नसल्यास</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 my-4 p-3 bg-light rounded">
                        <!-- क्षेत्रफळ -->
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="text-center mb-0">क्षेत्रफळ चौ. फुट</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <?php
                                    if(count($ranges) > 0){
                                        foreach($ranges as $row){
                                            echo '<li class="list-group-item">'.$row.'</li>';
                                        }
                                    }else{
                                        echo '<li class="list-group-item">क्षेत्रफळ माहिती उपलब्ध नाही</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <!-- आरोग्य कर -->
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="text-center mb-0">आरोग्य कर</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-4"><strong>किमान दर</strong></div>
                                        <div class="col-4"><strong>कमाल दर</strong></div>
                                        <div class="col-4"><strong>प्रा.पं. ठरवलेला दर</strong></div>
                                    </div>
                                    <?php
                                    if(mysqli_num_rows($taxInfosAarogya) > 0){
                                        $i = 0;
                                        while($row = mysqli_fetch_assoc($taxInfosAarogya)){
                                            $i = $row['id'];
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="health['.$i.'][kiman_rate]" class="form-control border-primary healthTax" value="'.$row['arogya_kiman_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '<div class="col-4"><input type="text" name="health['.$i.'][kamal_rate]" class="form-control border-primary healthTax" value="'.$row['arogya_kamal_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '<div class="col-4"><input type="text" name="health['.$i.'][tharabaila_rate]" class="form-control border-primary healthTax" value="'.$row['arogya_prap_tharabaila_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '</div>';
                                            $i++;
                                        }
                                        for($j = $i; $j < 3; $j++) {
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="health['.$j.'][kiman_rate]" class="form-control border-primary healthTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="health['.$j.'][kamal_rate]" class="form-control border-primary healthTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="health['.$j.'][tharabaila_rate]" class="form-control border-primary healthTax" value=""></div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        for($i = 0; $i < 3; $i++) {
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="health['.$i.'][kiman_rate]" class="form-control border-primary healthTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="health['.$i.'][kamal_rate]" class="form-control border-primary healthTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="health['.$i.'][tharabaila_rate]" class="form-control border-primary healthTax" value=""></div>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- दिवाबत्ती कर -->
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="text-center mb-0">दिवाबत्ती कर</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-4"><strong>किमान दर</strong></div>
                                        <div class="col-4"><strong>कमाल दर</strong></div>
                                        <div class="col-4"><strong>प्रा.पं. ठरवलेला दर</strong></div>
                                    </div>
                                    <?php
                                    if(mysqli_num_rows($taxInfosDivabatti) > 0){
                                        $i = 0;
                                        while($row = mysqli_fetch_assoc($taxInfosDivabatti)){
                                            $i = $row['id'];
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][kiman_rate]" class="form-control border-primary incomeTax" value="'.$row['divabatti_kiman_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][kamal_rate]" class="form-control border-primary incomeTax" value="'.$row['divabatti_kamal_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][tharabaila_rate]" class="form-control border-primary incomeTax" value="'.$row['divabatti_prap_tharabaila_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '</div>';
                                            $i++;
                                        }
                                        for($j = $i; $j < 3; $j++) {
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$j.'][kiman_rate]" class="form-control border-primary incomeTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$j.'][kamal_rate]" class="form-control border-primary incomeTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$j.'][tharabaila_rate]" class="form-control border-primary incomeTax" value=""></div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        for($i = 0; $i < 3; $i++) {
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][kiman_rate]" class="form-control border-primary incomeTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][kamal_rate]" class="form-control border-primary incomeTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][tharabaila_rate]" class="form-control border-primary incomeTax" value=""></div>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- सफाई कर -->
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="text-center mb-0">सफाई कर</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-4"><strong>किमान दर</strong></div>
                                        <div class="col-4"><strong>कमाल दर</strong></div>
                                        <div class="col-4"><strong>प्रा.पं. ठरवलेला दर</strong></div>
                                    </div>
                                    <?php
                                    if(mysqli_num_rows($taxInfosSafai) > 0){
                                        $i = 0;
                                        while($row = mysqli_fetch_assoc($taxInfosSafai)){
                                            $i = $row['id'];
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="safai['.$i.'][kiman_rate]" class="form-control border-primary safaiTax" value="'.$row['safai_kiman_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '<div class="col-4"><input type="text" name="safai['.$i.'][kamal_rate]" class="form-control border-primary safaiTax" value="'.$row['safai_kamal_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '<div class="col-4"><input type="text" name="safai['.$i.'][tharabaila_rate]" class="form-control border-primary safaiTax" value="'.$row['safai_prap_tharabaila_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                            echo '</div>';
                                            $i++;
                                        }
                                        for($j = $i; $j < 3; $j++) {
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="safai['.$j.'][kiman_rate]" class="form-control border-primary safaiTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="safai['.$j.'][kamal_rate]" class="form-control border-primary safaiTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="safai['.$j.'][tharabaila_rate]" class="form-control border-primary safaiTax" value=""></div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        for($i = 0; $i < 3; $i++) {
                                            echo '<div class="row g-2 mt-2">';
                                            echo '<div class="col-4"><input type="text" name="safai['.$i.'][kiman_rate]" class="form-control border-primary safaiTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="safai['.$i.'][kamal_rate]" class="form-control border-primary safaiTax" value=""></div>';
                                            echo '<div class="col-4"><input type="text" name="safai['.$i.'][tharabaila_rate]" class="form-control border-primary safaiTax" value=""></div>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <!-- सूचना -->
                    <div class="alert alert-info mt-4 text-center">
                        <strong>टीप:</strong> ग्रामपंचायती मध्ये आरोग्य व दिवाबत्ती कराची वसुली जर करत नसेल तर त्या करिता आरोग्य व दिवाबत्ती कर नसल्याचा Check Box वर Click करावे.
                    </div>

                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <button type="submit" name="add" id="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>साठवणे
                        </button>
                        <button type="reset" class="btn btn-outline-danger px-4">
                            <i class="fas fa-times me-2"></i>रद्द करणे
                        </button>
                        <button type="submit" name="update" id="update" class="btn btn-primary px-4">
                            <i class="fas fa-edit me-2"></i>बदल
                        </button>
                    </div>
                </form>
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
    function filldata(id, period_start, period_end, total_period, period_reason) {
        // Set hidden input field with row ID
        document.getElementById('update').value = id;

        // Set reason dropdown
        const reasonSelect = document.getElementById('reason');
        for (let option of reasonSelect.options) {
            if (option.text === period_reason) {
                reasonSelect.value = option.value;
                break;
            }
        }

        // Enable date inputs and populate values
        document.getElementById('durationStart').disabled = false;
        document.getElementById('durationEnd').disabled = false;

        document.getElementById('durationStart').value = period_start;
        document.getElementById('durationEnd').value = period_end;
        document.getElementById('duration').value = total_period;

        // Enable submit button
        document.getElementById('submit').disabled = false;
    }

    document.addEventListener("DOMContentLoaded", function() {
        const healthTaxCheckbox = document.getElementById("healthTax");
        const noTaxCheckbox = document.getElementById("lightTax");
        const noSafaiTaxCheckbox = document.getElementById("safaiTax");

        const healthTaxInputs = document.querySelectorAll(".healthTax");
        const incomeTaxInputs = document.querySelectorAll(".incomeTax");
        const safaiTaxInputs = document.querySelectorAll(".safaiTax");

        function toggleTaxInputs() {
            const isHealthChecked = healthTaxCheckbox.checked;
           

            // Health Tax inputs
            if (isHealthChecked) {
                healthTaxInputs.forEach(input => {
                    input.readOnly = true; // Clear the value if checked
                });
            } else {
                healthTaxInputs.forEach(input => {
                    input.readOnly = false; // Clear the value if checked
                });
            }

           
        }
        function noTaxToggleInputs(){
 const isNoTaxChecked = noTaxCheckbox.checked;
  if (isNoTaxChecked) {
                incomeTaxInputs.forEach(input => {
                    input.readOnly = true; // Clear the value if checked
                });
            } else {
                incomeTaxInputs.forEach(input => {
                    input.readOnly = false; // Clear the value if checked
                });
            }
        }
        
        function toggleSafaiTaxInputs(){
            const isNotSafaiChecked = noSafaiTaxCheckbox.checked;
 if(isNotSafaiChecked){
                safaiTaxInputs.forEach(input => {
                    input.readOnly = true; // Clear the value if checked
                });
            }else{
                safaiTaxInputs.forEach(input => {
                    input.readOnly = false; // Clear the value if checked
                });
            }
        }
        healthTaxCheckbox.addEventListener("change", toggleTaxInputs);
        noTaxCheckbox.addEventListener("change", noTaxToggleInputs);
        noSafaiTaxCheckbox.addEventListener("change", toggleSafaiTaxInputs);
    });
    </script>
</body>

</html>