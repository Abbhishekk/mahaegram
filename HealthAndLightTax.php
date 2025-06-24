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
     $taxInfosAarogya = $fun->getTaxInfo($_SESSION['district_code']);
    $taxInfosDivabatti = $fun->getTaxInfo($_SESSION['district_code']);
    $taxInfosSafai = $fun->getTaxInfo($_SESSION['district_code']);
    $isTharavExists = $fun->isTharavExists($periods['total_period']);
    $getTharavByPeriod = $fun->getTharavByPeriod($periods['total_period']);
    if (mysqli_num_rows($getTharavByPeriod) > 0) {
        // print_r($getTharavByPeriod);
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
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
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
                            <div class="card mb-4">
                                <?php

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];

    echo "<div class='alert alert-$message_type'>$message</div>";

    // Unset the message so it doesn't persist after refresh
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
                                <div class="card-body">

                                    <form method="post" action="api/healthAndTax.php">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="period">नमुना ८ कालावधी करिता <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="period" id="period"
                                                    value="<?php echo $periods['total_period']; ?>" class="form-control"
                                                    readonly>

                                                <input type="number" value="" class="form-control d-none" name="update"
                                                    id="update" aria-describedby="emailHelp">

                                            </div>

                                            <div class="form-group col-md-2" id="simple-date1">
                                                <label for="decisionDate">ठराव दिनांक <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <input type="date" required class="form-control" name="decisionDate"
                                                        value="" id="decisionDate">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2" id="simple-date1">
                                                <label for="durationEnd">ठराव क्रमांक <span class="text-danger">*</span>
                                                </label>


                                                <input type="text" class="form-control" name="descisionNo"
                                                    value="<?php echo ($row == null? "" : $row['tharav_no'])?>"
                                                    <?php echo ($isTharavExists)?"disabled":"" ?> id="descisionNo">

                                            </div>
                                            <div class="col-12 my-3" ></div>
                                            <div class="form-group col-md-2" id="simple-date1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="healthTax"
                                                        name="healthTax" value="healthTax"
                                                        <?php echo ($isTharavExists)?"disabled":"" ?>>
                                                    <label class="custom-control-label" for="healthTax">आरोग्य कर
                                                        नसल्यास</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2" id="simple-date1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="lightTax"
                                                        <?php echo ($isTharavExists)?"disabled":"" ?> name="lightTax"
                                                        value="lightTax">
                                                    <label class="custom-control-label" for="lightTax">दिवाबत्ती कर
                                                        नसल्यास</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2" id="simple-date1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="safaiTax"
                                                        <?php echo ($isTharavExists)?"disabled":"" ?> name="safaiTax"
                                                        value="safaiTax">
                                                    <label class="custom-control-label" for="safaiTax">सफाई कर
                                                        नसल्यास</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div
                                            class="row g-3 d-flex align-items-end justify-content-between my-5 shadow p-3 mb-5 bg-body rounded mx-5">
                                            <!-- क्षेत्रफळ -->
                                            <div class="col-md-3">
                                                <div class="">
                                                    <h5 class="text-center">क्षेत्रफळ चौ. फुट</h5>
                                                    <ul class="list-group list-group-flush">
                                                        <?php
                                                            if(mysqli_num_rows($taxInfosArea) > 0){
                                                                while($row = mysqli_fetch_assoc($taxInfosArea)){
                                                                    echo '<li class="list-group-item">'.$row['area_range'].'</li>';
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
                                                <div class="">
                                                    <h5 class="text-center">आरोग्य कर</h5>
                                                    <div class="row">
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
                                                                echo '<div class="col-4"><input type="text" name="health['.$i.'][kiman_rate]" class="form-control healthTax" value="'.$row['arogya_kiman_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '<div class="col-4"><input type="text" name="health['.$i.'][kamal_rate]" class="form-control healthTax" value="'.$row['arogya_kamal_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '<div class="col-4"><input type="text" name="health['.$i.'][tharabaila_rate]" class="form-control healthTax" value="'.$row['arogya_prap_tharabaila_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '</div>';
                                                                $i++;
                                                            }
                                                        }else{
                                                            echo '<div class="row g-2 mt-2">';
                                                            echo '<div class="col-4"><input type="text" class="form-control healthTax" value=""></div>';
                                                            echo '<div class="col-4"><input type="text" class="form-control healthTax" value=""></div>';
                                                            echo '<div class="col-4"><input type="text" class="form-control healthTax" value=""></div>';
                                                            echo '</div>';
                                                        }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- दिवाबत्ती कर -->
                                            <div class="col-md-3">
                                                <div class="">
                                                    <h5 class="text-center">दिवाबत्ती कर</h5>
                                                    <div class="row">
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
                                                                echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][kiman_rate]" class="form-control incomeTax" value="'.$row['divabatti_kiman_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][kamal_rate]" class="form-control incomeTax" value="'.$row['divabatti_kamal_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '<div class="col-4"><input type="text" name="divabatti['.$i.'][tharabaila_rate]" class="form-control incomeTax" value="'.$row['divabatti_prap_tharabaila_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '</div>';
                                                                $i++;
                                                            }
                                                        }else{
                                                            echo '<div class="row g-2 mt-2">';
                                                            echo '<div class="col-4"><input type="text" class="form-control incomeTax" value=""></div>';
                                                            echo '<div class="col-4"><input type="text" class="form-control incomeTax" value=""></div>';
                                                            echo '<div class="col-4"><input type="text" class="form-control incomeTax" value=""></div>';
                                                            echo '</div>';
                                                        }
                                                    ?>

                                                </div>
                                            </div>
                                            <!-- सफाई कर -->
                                            <div class="col-md-3">
                                                <div class="">
                                                    <h5 class="text-center">सफाई कर</h5>
                                                    <div class="row">
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
                                                                echo '<div class="col-4"><input type="text" name="safai['.$i.'][kiman_rate]" class="form-control safaiTax" value="'.$row['safai_kiman_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '<div class="col-4"><input type="text" name="safai['.$i.'][kamal_rate]" class="form-control safaiTax" value="'.$row['safai_kamal_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '<div class="col-4"><input type="text" name="safai['.$i.'][tharabaila_rate]" class="form-control safaiTax" value="'.$row['safai_prap_tharabaila_rate'].'" '.( $row['status']? "": "readonly").'></div>';
                                                                echo '</div>';
                                                                $i++;
                                                            }
                                                        }else{
                                                            echo '<div class="row g-2 mt-2">';
                                                            echo '<div class="col-4"><input type="text" class="form-control safaiTax" value=""></div>';
                                                            echo '<div class="col-4"><input type="text" class="form-control safaiTax" value=""></div>';
                                                            echo '<div class="col-4"><input type="text" class="form-control safaiTax" value=""></div>';
                                                            echo '</div>';
                                                        }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>  

                                        <!-- सूचना -->
                                        <p class="my-5 text-center text-danger">
                                            टीप: ग्रामपंचायती मध्ये आरोग्य व दिवाबत्ती कराची वसुली जर करत नसेल तर त्या
                                            करिता आरोग्य व दिवाबत्ती कर नसल्याचा Check Box वर Click करावे.
                                        </p>

                                        <button type="submit" name="add" id="submit"
                                            class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                        <button type="submit" name="update" id="update"
                                            class="btn btn-primary">बदल</button>
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