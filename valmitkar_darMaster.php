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
    $periods = $fun->getPeriodDetailsLastValue($_SESSION['district_code']);
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
    }else{
        $minDar = null;
    }
    $maxDar = $fun->getMilkatTaxInfoDarMax($_SESSION['district_code']);
    if(mysqli_num_rows($maxDar) > 0){
        $maxDar = mysqli_fetch_assoc($maxDar);
    }else{
        $maxDar = null;
    }
    $dar = $fun->getMilkatTaxInfoDarCons($_SESSION['district_code']);
    if(mysqli_num_rows($dar) > 0){
        $dar = mysqli_fetch_assoc($dar);
    }else{
        $dar = null;
    }
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
                        <h1 class="h3 mb-0 text-gray-800">मिळकत कर दर माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">मिळकत कर दर माहिती</li>
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

                                    <form method="post" action="api/milkat_dar.php">
                                        <div class="row">
                                            <div class="form-group col-md-3 mx-auto">
                                                <label for="period">कालावधी <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="period" id="period"
                                                    value="<?php echo $periods['total_period']; ?>" class="form-control"
                                                    readonly>

                                                <input type="number" value="" class="form-control d-none" name="update"
                                                    id="update" aria-describedby="emailHelp">

                                            </div>



                                        </div>


                                        <div class="container mt-4">
                                            <!-- <h3 class="text-center">मिळकत कर प्रकार</h3> -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped text-start">
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
                                                        <tr>
                                                            <td>१. कच्चे घर (झोपडी किंवा मातीचे घर)</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['kache_ghar']?>"
                                                                    name="minDar_kache_ghar" class="form-control"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['kache_ghar']?>"
                                                                    name="maxDar_kache_ghar" class="form-control"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_kache_ghar"
                                                                    value="<?php echo $fixedDar['kache_ghar']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="construction_kache_ghar"
                                                                    value="<?php echo $dar['kache_ghar']?>" readonly>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>२. अर्ध पक्के घर (दगड विटांचे मातीचे घर)</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['ardha_pakke_ghar']?>"
                                                                    name="minDar_ardha_pakke_ghar" class="form-control"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['ardha_pakke_ghar']?>"
                                                                    name="maxDar_ardha_pakke_ghar" class="form-control"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_ardha_pakke_ghar"
                                                                    value="<?php echo $fixedDar['ardha_pakke_ghar']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['ardha_pakke_ghar']?>"
                                                                    name="construction_ardha_pakke_ghar" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>३. पडसर / खुली जागा</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['padsar']?>"
                                                                    name="minDar_padsar" class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['padsar']?>"
                                                                    name="maxDar_padsar" class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_padsar"
                                                                    value="<?php echo $fixedDar['padsar']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="construction_padsar"
                                                                    value="<?php echo $dar['padsar']?>" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>४. इतर पक्के घर</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['itar_pakke_ghar']?>"
                                                                    name="minDar_itar_pakke_ghar" class="form-control"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['itar_pakke_ghar']?>"
                                                                    name="maxDar_itar_pakke_ghar" class="form-control"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_itar_pakke_ghar"
                                                                    value="<?php echo $fixedDar['itar_pakke_ghar']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['itar_pakke_ghar']?>"
                                                                    name="construction_itar_pakke_ghar" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>५. आरसीसी पद्धतीचे बांधकाम</td>
                                                            <td><input type="text" value="<?php echo $minDar['rcc']?>"
                                                                    name="minDar_rcc" class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text" value="<?php echo $maxDar['rcc']?>"
                                                                    name="maxDar_rcc" class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_rcc"
                                                                    value="<?php echo $fixedDar['rcc']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['rcc']?>"
                                                                    name="construction_rcc" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>६. मनोरा टाइप घर</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['manora_type_ghar']?>"
                                                                    name="minDar_manora_type_ghar" class="form-control"
                                                                    readonly></td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['manora_type_ghar']?>"
                                                                    name="maxDar_manora_type_ghar" class="form-control"
                                                                    readonly></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_manora_type_ghar"
                                                                    value="<?php echo $fixedDar['manora_type_ghar']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['manora_type_ghar']?>"
                                                                    name="construction_manora_type_ghar" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>७. मनोरा खुली जागा सर्वसाधारण</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['manora_khuli_jaga_sarvasadharan']?>"
                                                                    name="minDar_manora_khuli_jaga_sarvasadharan"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['manora_khuli_jaga_sarvasadharan']?>"
                                                                    name="maxDar_manora_khuli_jaga_sarvasadharan"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_manora_khuli_jaga_sarvasadharan"
                                                                    value="<?php echo $fixedDar['manora_khuli_jaga_sarvasadharan']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['manora_khuli_jaga_sarvasadharan']?>"
                                                                    name="construction_manora_khuli_jaga_sarvasadharan"
                                                                    readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>८. मनोरा खुली जागा महानगरपालिका</td>
                                                            <td><input type="text"
                                                                    value="<?php echo $minDar['manora_khuli_jaga_mnc']?>"
                                                                    name="minDar_manora_khuli_jaga_mnc"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text"
                                                                    value="<?php echo $maxDar['manora_khuli_jaga_mnc']?>"
                                                                    name="maxDar_manora_khuli_jaga_mnc"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="decided_manora_khuli_jaga_mnc"
                                                                    value="<?php echo $fixedDar['manora_khuli_jaga_mnc']?>"
                                                                    <?php echo $isFixedAvailable ? ("readonly"): ("")?>>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    value="<?php echo $dar['manora_khuli_jaga_mnc']?>"
                                                                    name="construction_manora_khuli_jaga_mnc" readonly>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="text-center mt-3">
                                                <button type="submit" name="add" id="submit" class="btn btn-primary"
                                                    <?php echo $isFixedAvailable ? ("disabled"): ("") ?>>साठवणे</button>
                                                <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                                <button class="btn btn-success">बदल</button>
                                            </div>
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