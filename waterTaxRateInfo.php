<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "पाणीपट्टी दर माहिती";
?>
<?php include('include/header.php'); ?>
<?php
$waterTariff = $fun->getWaterTariff($_SESSION['district_code']);
$durationReason = $fun->getDurationReason();
$drainageTypes = $fun->getDrainageTypes();
$periodTotalPeriod = $fun->getPeriodTotalPeriodsWithPeriodReason("पाणीपट्टी कालावधी", $_SESSION['district_code']);
$periodCount = mysqli_num_rows($periodTotalPeriod);
if ($periodCount == 0) {
    $_SESSION['message'] = "⚠️ कृपया पाणीपट्टी कालावधी आधीच भरा!";
    $_SESSION['message_type'] = "danger";
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
                        <h1 class="h3 mb-0 text-gray-800">पाणीपट्टी दर माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">पाणीपट्टी दर माहिती</li>
                        </ol>
                    </div>

                   <div class="row mb-3">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">पाणीपट्टी कर व्यवस्थापन</h6>
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
                <form method="post" action="api/waterTax.php">
                    <div class="row g-3">
                        <!-- पाणीपट्टी प्रकार -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select border-primary" name="drainageType" id="drainageType" required>
                                    <option value="" selected>-- पाणीपट्टी प्रकार निवडा-</option>
                                    <?php
                                    if (mysqli_num_rows($drainageTypes) > 0) {
                                        while ($drainageType = mysqli_fetch_assoc($drainageTypes)) {
                                            echo "<option value='" . $drainageType['drainage_type'] . "'>" . $drainageType['drainage_type'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="drainageType">पाणीपट्टी प्रकार <span class="text-danger">*</span></label>
                                <input type="number" value="" class="form-control d-none" name="update" id="update">
                            </div>
                        </div>

                        <!-- कालावधी -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select border-primary" name="period" id="period" required>
                                    <option value="" selected>--कालावधी निवडा--</option>
                                    <?php
                                    if (mysqli_num_rows($periodTotalPeriod) > 0) {
                                        while ($totalPerios = mysqli_fetch_assoc($periodTotalPeriod)) {
                                            echo "<option value='" . $totalPerios['id'] . "'>" . $totalPerios['total_period'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="period">कालावधी <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <!-- नळ जोडणी व्यास -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select border-primary" name="pip_connection" id="pip_connection" required>
                                    <option value="">--नळ जोडणी व्यास निवडा--</option>
                                    <option value="1/2">1/2</option>
                                    <option value="1">1</option>
                                    <option value="3/4">3/4</option>
                                </select>
                                <label for="pip_connection">नळ जोडणी व्यास <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <!-- दर माहिती -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="min_tax" id="min_tax" 
                                       placeholder="किमान दर" required>
                                <label for="min_tax">किमान दर <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="max_tax" id="max_tax" 
                                       placeholder="कमाल दर" required>
                                <label for="max_tax">कमाल दर <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="fixed_tax" id="fixed_tax" 
                                       placeholder="ठरवलेला दर" required>
                                <label for="fixed_tax">ठरवलेला दर <span class="text-danger">*</span></label>
                                <p class="text-danger small mt-1" id="fixed_tax_error"></p>
                            </div>
                        </div>

                        <!-- ठराव माहिती -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control border-primary" name="decision_date" 
                                           id="decision_date" required>
                                </div>
                                <label for="decision_date"><span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control border-primary" name="resolution_no" 
                                       id="resolution_no" placeholder="ठराव क्र." required>
                                <label for="resolution_no">ठराव क्र. <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- टीप -->
                    <div class="alert alert-warning mt-4 text-center">
                        <strong>टीप:</strong> नमुना क्र. ८ स्वयंनिर्मिती (Auto) करण्याकरिता व अहवाल मध्ये सामान्य पाणीपट्टी चा कर दिसून येण्याकरिता सामान्य पाणीपट्टी कर नोंद करणे अनिवार्य आहे.
                    </div>

                    <!-- बटणे -->
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <button type="submit" name="add" id="add" class="btn btn-primary px-4">
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
                <h6 class="m-0 font-weight-bold text-white">पाणीपट्टी कर यादी</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>अ.क्र.</th>
                            <th>प्रकार</th>
                            <th>नळ जोडणी साइज</th>
                            <th>किमान दर</th>
                            <th>कमाल दर</th>
                            <th>ठरवलेला दर</th>
                            <th>कालावधी</th>
                            <th>बदल</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($waterTariff) > 0) {
                            $i = 1;
                            while ($water = mysqli_fetch_assoc($waterTariff)) {
                        ?>
                        <tr>
                            <td><a href="#"><?php echo $i; ?></a></td>
                            <td><?php echo $water['drainage_type']; ?></td>
                            <td><?php echo $water['pipe_diameter']; ?></td>
                            <td><?php echo $water['min_rate']; ?></td>
                            <td><?php echo $water['max_rate']; ?></td>
                            <td><?php echo $water['fixed_rate']; ?></td>
                            <td><?php echo $water['total_period']; ?></td>
                            <td>
                                <a href="#" class="text-primary" 
                                   onclick="filldata('<?php echo $water['wt_id']; ?>', '<?php echo $water['drainage_type']; ?>', '<?php echo $water['pipe_diameter']; ?>', '<?php echo $water['min_rate']; ?>', '<?php echo $water['fixed_rate']; ?>', '<?php echo $water['pt_id']; ?>', '<?php echo $water['decision_date']; ?>', '<?php echo $water['resolution_no']; ?>')">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No data found</td></tr>";
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
        function filldata(id, drainage_type, pipe_diameter, min_rate, fixed_rate, total_period, decision_date,
            resolution_no) {
            // console.log(decision_date, id, drainage_type, pipe_diameter, min_rate, fixed_rate, total_period, decision_date,
            //     resolution_no);

            document.getElementById('update').value = id;
            document.getElementById('drainageType').value = drainage_type;
            document.getElementById('pip_connection').value = pipe_diameter;
            document.getElementById('min_tax').value = min_rate;
            document.getElementById('fixed_tax').value = fixed_rate;
            document.getElementById('period').value = total_period;
            document.getElementById('decision_date').value = decision_date;
            document.getElementById('resolution_no').value = resolution_no;
        }

        document.addEventListener("DOMContentLoaded", function() {
            const decision_date = document.getElementById('decision_date');

            decision_date.value = new Date().toISOString().split('T')[0];

        });
        document.addEventListener("DOMContentLoaded", function() {

            $("#drainageType").change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === "वापर नाही") {
                    $("#pip_connection").attr('disabled', 'true');
                    $("#pip_connection").removeAttr('required');
                } else {
                    $("#pip_connection").removeAttr('disabled');
                    $("#pip_connection").attr('required', 'true');
                }
            })
            const decision_date = document.getElementById('decision_date');
            decision_date.value = new Date().toISOString().split('T')[0];

            const minTaxEl = document.getElementById('min_tax');
            const maxTaxEl = document.getElementById('max_tax');
            const fixedTaxEl = document.getElementById('fixed_tax');
            const fixed_tax_error = document.getElementById('fixed_tax_error');
            const submitButton = document.getElementById('add');

            function validateFixedTax() {
                const minTax = parseFloat(minTaxEl.value);
                const maxTax = parseFloat(maxTaxEl.value);
                const fixedTax = parseFloat(fixedTaxEl.value);
                console.log(minTax, maxTax, fixedTax);

                if (!isNaN(minTax) && !isNaN(maxTax) && !isNaN(fixedTax)) {
                    if (fixedTax < minTax || fixedTax > maxTax) {
                        fixed_tax_error.innerText =
                            'ठरवलेला दर किमान दर आणि कमाल दर यामध्ये असावा. (Fixed tax must be between min and max tax.)';
                        fixedTaxEl.setCustomValidity(
                            'ठरवलेला दर किमान दर आणि कमाल दर यामध्ये असावा. (Fixed tax must be between min and max tax.)'
                        );
                        submitButton.disabled = true;
                    } else {
                        fixedTaxEl.setCustomValidity('');
                        fixed_tax_error.innerText = '';
                        submitButton.disabled = false;
                    }
                } else {
                    fixedTaxEl.setCustomValidity('');
                    fixed_tax_error.innerText = '';
                    submitButton.disabled = false;
                }
            }

            // Attach real-time validation
            fixedTaxEl.addEventListener('change', validateFixedTax);
            minTaxEl.addEventListener('change', validateFixedTax);
            maxTaxEl.addEventListener('change', validateFixedTax);
        });
    </script>
</body>

</html>