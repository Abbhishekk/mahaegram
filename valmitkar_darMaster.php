<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "मिळकत कर दर माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $durationReason = $fun->getDurationReason();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
    $periods = $fun->getPeriodDetailsLastValueByPeriodReason("नमुना नंबर 8 कालावधी",$_SESSION['district_code']);
    $minDar = $fun->getMilkatTaxInfoDarMin($_SESSION['district_code']);
    $fixedDar = $fun->getMilkatTaxInfoDarFixed($_SESSION['district_code']);
    if(mysqli_num_rows($fixedDar) > 0){
        $fixedDar = mysqli_fetch_assoc($fixedDar);
        $isFixedAvailable = true;
    }else{
        $fixedDar = null;
        $isFixedAvailable = false;
    }
    if(mysqli_num_rows($minDar) > 0){
        $minDar = mysqli_fetch_assoc($minDar);
        $isMinAvailable = false;
    }else{
        $minDar = null;
        $isMinAvailable = true;
    }
    $maxDar = $fun->getMilkatTaxInfoDarMax($_SESSION['district_code']);
    if(mysqli_num_rows($maxDar) > 0){
        $maxDar = mysqli_fetch_assoc($maxDar);
        $isMaxAvailable = false;
    }else{
        $maxDar = null;
        $isMaxAvailable = true;
    }
    $dar = $fun->getMilkatTaxInfoDarCons($_SESSION['district_code']);
    if(mysqli_num_rows($dar) > 0){
        $dar = mysqli_fetch_assoc($dar);
        $isDarAvailable = false;
    }else{
        $dar = null;
        $isDarAvailable = true;
    }
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
        include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">मिळकत कर दर माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल </a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">मिळकत कर दर माहिती</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">मिळकत कर दर व्यवस्थापन</h6>
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
                <form method="post" action="api/milkat_dar.php">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="period" id="period" 
                                       value="<?php echo $periods['total_period']; ?>" readonly>
                                <label for="period">कालावधी <span class="text-danger">*</span></label>
                                <input type="number" value="" class="form-control d-none" name="update" id="update">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>मिळकत कर प्रकार</th>
                                    <th>किमान</th>
                                    <th>कमाल</th>
                                    <th>प्रा.पं.ने ठरवलेला दर</th>
                                    <th>बांधकाम दर</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                <tr>
                                    <td>१. कच्चे घर (झोपडी किंवा मातीचे घर)</td>
                                    <td><input type="text" value="<?php echo $minDar['kache_ghar'] ?? "0.3" ?>"
                                            name="minDar_kache_ghar" class="form-control border-primary" readonly></td>
                                    <td><input type="text" value="<?php echo $maxDar['kache_ghar'] ?? "0.75"?>"
                                            name="maxDar_kache_ghar" class="form-control border-primary" readonly></td>
                                    <td><input type="text" class="form-control border-primary"
                                            name="decided_kache_ghar"
                                            value="<?php echo (isset($fixedDar['kache_ghar'])?($fixedDar['kache_ghar']):("0.00"))?>"
                                            <?php echo $isFixedAvailable ? "readonly" : "" ?>></td>
                                    <td><input type="text" class="form-control border-primary"
                                            name="construction_kache_ghar"
                                            value="<?php echo $dar['kache_ghar'] ?? "0"?>" 
                                            <?php echo $isDarAvailable ? "" : "readonly" ?>></td>
                                </tr>
                                
                                <!-- Row 2 -->
                                <tr>
                                    <td>२. अर्ध पक्के घर (दगड विटांचे मातीचे घर)</td>
                                    <td><input type="text" value="<?php echo $minDar['ardha_pakke_ghar'] ?? "0.6" ?>"
                                            name="minDar_ardha_pakke_ghar" class="form-control border-primary" readonly></td>
                                    <td><input type="text" value="<?php echo $maxDar['ardha_pakke_ghar'] ?? "1.2" ?>"
                                            name="maxDar_ardha_pakke_ghar" class="form-control border-primary" readonly></td>
                                    <td><input type="text" class="form-control border-primary"
                                            name="decided_ardha_pakke_ghar"
                                            value="<?php echo $isFixedAvailable? $fixedDar['ardha_pakke_ghar']: "0.00"?>"
                                            <?php echo $isFixedAvailable ? "readonly" : "" ?>></td>
                                    <td><input type="text" class="form-control border-primary"
                                            value="<?php echo $dar['ardha_pakke_ghar'] ?? "0" ?>" 
                                            <?php echo $isDarAvailable ? "" : "readonly" ?>
                                            name="construction_ardha_pakke_ghar"></td>
                                </tr>
                                
                                <tr>
                                                            <td>३. पडसर / खुली जागा</td>
                                                            <td><input type="text" value="<?php echo $minDar['padsar'] ?? "1.5" ?>"
                                                                    name="minDar_padsar" class="form-control border-primary" readonly>
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['padsar'] ?? "5" ?>"
                                                                    name="maxDar_padsar" class="form-control border-primary" readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_padsar"
                                                                    value="<?php echo $isFixedAvailable? $fixedDar['padsar']: ("0.00")?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control border-primary"
                                                                    name="construction_padsar"
                                                                    value="<?php echo $dar['padsar'] ?? "0" ?>" <?php echo $isDarAvailable ? (""): ("readonly")?> ></td>
                                                        </tr>
                                                        
                            <tr>
                                                            <td>४. इतर पक्के घर</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['itar_pakke_ghar'] ?? "0.75" ?>"
                                                                    name="minDar_itar_pakke_ghar" class="form-control" readonly
                                                                    >
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['itar_pakke_ghar'] ?? "1.5" ?>"
                                                                    name="maxDar_itar_pakke_ghar" class="form-control" readonly 
                                                                    >
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_itar_pakke_ghar"
                                                                    value="<?php echo $isFixedAvailable? $fixedDar['itar_pakke_ghar']: ("0.00")?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['itar_pakke_ghar'] ?? "0" ?>" <?php echo $isDarAvailable ? (""): ("readonly")?>
                                                                    name="construction_itar_pakke_ghar"></td>
                                                        </tr>
                                                        
                            <tr>
                                                            <td>५. आरसीसी पद्धतीचे बांधकाम</td>
                                                            <td><input type="text" value="<?php echo $minDar['rcc'] ?? "1.2" ?>"
                                                                    name="minDar_rcc" class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text" value="<?php echo $maxDar['rcc'] ?? "2" ?>"
                                                                    name="maxDar_rcc" class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_rcc"
                                                                    value="<?php echo $isFixedAvailable? $fixedDar['rcc']: ("0.00")?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['rcc'] ?? "0" ?>" <?php echo $isDarAvailable ? (""): ("readonly")?> 
                                                                    name="construction_rcc"></td>
                                                        </tr>
                                                                                                                <tr>
                                                            <td>६. मनोरा टाइप घर</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['manora_type_ghar'] ?? "3" ?>"
                                                                    name="minDar_manora_type_ghar" class="form-control" readonly
                                                                    ></td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['manora_type_ghar'] ?? "8" ?>"
                                                                    name="maxDar_manora_type_ghar" class="form-control" readonly
                                                                    ></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_manora_type_ghar"
                                                                    value="<?php echo $isFixedAvailable? $fixedDar['manora_type_ghar']: ("0.00")?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['manora_type_ghar'] ?? "0" ?>" <?php echo $isDarAvailable ? (""): ("readonly")?>
                                                                    name="construction_manora_type_ghar" ></td>
                                                        </tr>
                                                        <tr>
                                                            <td>७. मनोरा खुली जागा सर्वसाधारण</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['manora_khuli_jaga_sarvasadharan'] ?? "0.2" ?>"
                                                                    name="minDar_manora_khuli_jaga_sarvasadharan" readonly
                                                                    class="form-control" >
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['manora_khuli_jaga_sarvasadharan'] ?? "0.4" ?>"
                                                                    name="maxDar_manora_khuli_jaga_sarvasadharan" readonly
                                                                    class="form-control" >
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_manora_khuli_jaga_sarvasadharan"
                                                                    value="<?php echo $isFixedAvailable? $fixedDar['manora_khuli_jaga_sarvasadharan']: ("0.00")?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['manora_khuli_jaga_sarvasadharan'] ?? "0" ?>"
                                                                    name="construction_manora_khuli_jaga_sarvasadharan" <?php echo $isDarAvailable ? (""): ("readonly")?>
                                                                    ></td>
                                                        </tr>
                                
                                
                                
                                <!-- Row 8 -->
                                <tr>
                                    <td>८. मनोरा खुली जागा महानगरपालिका</td>
                                    <td><input type="text" value="<?php echo $minDar['manora_khuli_jaga_mnc'] ?? "0.4" ?>"
                                            name="minDar_manora_khuli_jaga_mnc" readonly
                                            class="form-control border-primary"></td>
                                    <td><input type="text" value="<?php echo $maxDar['manora_khuli_jaga_mnc'] ?? "0.8" ?>"
                                            name="maxDar_manora_khuli_jaga_mnc" readonly
                                            class="form-control border-primary"></td>
                                    <td><input type="text" class="form-control border-primary"
                                            name="decided_manora_khuli_jaga_mnc"
                                            value="<?php echo $isFixedAvailable? $fixedDar['manora_khuli_jaga_mnc']: "0.00"?>"
                                            <?php echo $isFixedAvailable ? "readonly" : "" ?>></td>
                                    <td><input type="text" class="form-control border-primary"
                                            value="<?php echo $dar['manora_khuli_jaga_mnc'] ?? "0" ?>" 
                                            <?php echo $isDarAvailable ? "" : "readonly" ?>
                                            name="construction_manora_khuli_jaga_mnc"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="submit" name="add" id="submit" class="btn btn-primary px-4"
                            <?php echo $isFixedAvailable ? "disabled" : "" ?>>
                            <i class="fas fa-save me-2"></i>साठवणे
                        </button>
                        <button type="reset" class="btn btn-outline-danger px-4">
                            <i class="fas fa-times me-2"></i>रद्द करणे
                        </button>
                        <button type="button" class="btn btn-success px-4">
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
        const reasonSelect = document.getElementById("reason");
        const durationStart = document.getElementById("durationStart");
        const durationEnd = document.getElementById("durationEnd");
        const duration = document.getElementById("duration");
        const submitButton = document.getElementById("submit");

        // Disable fields initially
        durationStart.disabled = true;
        durationEnd.disabled = true;
        submitButton.disabled = true;

        // Function to update duration field
        function updateDuration() {
            const startDate = new Date(durationStart.value);
            const endDate = new Date(durationEnd.value);

            if (!isNaN(startDate) && !isNaN(endDate)) {
                duration.value = `${startDate.getFullYear()}-${endDate.getFullYear()}`;
                checkSubmitCondition();
            }
        }

        // Enable date inputs when a reason is selected
        reasonSelect.addEventListener("change", function() {
            if (this.value) {
                const today = new Date().toISOString().split("T")[0];
                durationStart.disabled = false;
                durationEnd.disabled = false;
                durationStart.value = today;
                durationEnd.value = today;
                updateDuration();
            } else {
                durationStart.disabled = true;
                durationEnd.disabled = true;
                submitButton.disabled = true;
                duration.value = "";
            }
        });

        // Update duration on date change
        durationStart.addEventListener("change", updateDuration);
        durationEnd.addEventListener("change", updateDuration);

        // Check if all fields are filled before enabling submit button
        function checkSubmitCondition() {
            if (reasonSelect.value && durationStart.value && durationEnd.value && duration.value) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
    });
    </script>
</body>

</html>