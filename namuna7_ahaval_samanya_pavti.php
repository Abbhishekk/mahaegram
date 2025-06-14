<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "नमुना नं.७ पावती रजिस्टर";
?>
<?php include('include/header.php'); ?>
<?php
$newName = $fun->getNewName();
$periods = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
if (empty($periods)) {
    $_SESSION['message'] = "कालावधी उपलब्ध नाही.";
    $_SESSION['message_type'] = "danger";

}
$financialYears = $fun->getYearArray($periods);
$wards = $fun->getWard($_SESSION['district_code']);

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna7';
        $subpage = 'ahaval';
        include('include/sidebar.php');
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->

                <div class="container-fluid border rounded p-3" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">नमुना नं.७ पावती रजिस्टर</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना नं.७ पावती रजिस्टर</li>
                        </ol>
                    </div>
                    <form action="">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                        }
                        ?>
                        <div class=" card row p-4">
                            <div class="col-md-12 mb-3">
                                <label class="me-4 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="bill_type" value="all_register" checked class="me-1">
                                    संपूर्ण रजिस्टर
                                </label>
                                <label class="me-4 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="bill_type" value="book_number" class="me-1"> बुक नंबर
                                    नुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-inline-block">
                                    <input type="radio" name="bill_type" value="jama_dinanknusar" class="me-1"> जमा
                                    दिनांकानुसार
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-inline-block">
                                    <input type="radio" name="bill_type" value="pavati_number_nusar" class="me-1"> पावती
                                    नंबर नुसार
                                </label>
                            </div>


                            <div class="row">

                                <div class="col-md-4 my-2">
                                    <label class="form-label fw-bold">आर्थिक वर्ष :</label>
                                    <select class="form-control border-primary" name="financial_year"
                                        id="financial_year">
                                        <option value=""> --निवडा-- </option>
                                        <?php foreach ($financialYears as $year): ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3 my-2">
                                    <label for="plan_name">फंडाचे नाव : <span class="text-danger">*</span></label>
                                    <select class="form-control" name="plan_name" id="plan_name">
                                        <option value="">--निवडा--</option>
                                        <option value="ग्रामनिधी">ग्रामनिधी</option>
                                        <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="book_number_div">
                                    <label for="book_number">बुक नंबर : <span class="text-danger">*</span></label>
                                    <select class="form-control" name="book_number" id="book_number">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="pavati_number_pasun_div">
                                    <label for="pavati_number_pasun">पावती नंबर पासून : <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="pavati_number_pasun" id="pavati_number_pasun">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="pavati_number_paryant_div">
                                    <label for="pavati_number_paryant">पावती नंबर पर्यत : <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="pavati_number_paryant"
                                        id="pavati_number_paryant">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="jama_date_pasun_div">
                                    <label for="jama_date_pasun">जमा दिनांक पासून : <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="jama_date_pasun" id="jama_date_pasun">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3 my-2" id="jama_date_paryant_div">
                                    <label for="jama_date_paryant">पर्यत : <span class="text-danger">*</span></label>
                                    <select class="form-control" name="jama_date_paryant" id="jama_date_paryant">
                                        <option value="">--निवडा--</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3 d-flex justify-content-center  ">
                                <button type="submit" class="btn btn-primary me-2 mx-4">तपशील पहा</button>
                                <button class="btn btn-danger">रद्द करणे</button>
                            </div>
                        </div>
                    </form>
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
        function filldata(id, person_name, nickname, mobile_no, aadhar_no, email, gender) {
            console.log(id, person_name, nickname, mobile_no, aadhar_no, email, gender);

            document.getElementById('update').value = id;
            document.getElementById('person_name').value = person_name;
            document.getElementById('nickname').value = nickname;
            document.getElementById('mobile_no').value = mobile_no;
            document.getElementById('aadhar_no').value = aadhar_no;
            document.getElementById('email').value = email;
            document.getElementById('gender').value = gender;
        }


        $(document).ready(function () {
            // Show/hide fields based on selected report type
            $("#book_number_div").hide();
            $("#pavati_number_pasun_div").hide();
            $("#pavati_number_paryant_div").hide();
            $("#jama_date_pasun_div").hide();
            $("#jama_date_paryant_div").hide();

            $('input[name="bill_type"]').change(function () {
                if ($(this).val() === 'all_register') {
                    $('#book_number_div').hide();
                    $('#pavati_number_pasun_div').hide();
                    $('#pavati_number_paryant_div').hide();
                    $('#jama_date_pasun_div').hide();
                    $('#jama_date_paryant_div').hide();
                } else if ($(this).val() === 'book_number') {
                    $('#book_number_div').show();
                    $('#pavati_number_pasun_div').hide();
                    $('#pavati_number_paryant_div').hide();
                    $('#jama_date_pasun_div').hide();
                    $('#jama_date_paryant_div').hide();
                } else if ($(this).val() === 'jama_dinanknusar') {
                    $('#jama_date_pasun_div').show();
                    $('#jama_date_paryant_div').show();
                    $('#book_number_div').hide();
                    $('#pavati_number_pasun_div').hide();
                    $('#pavati_number_paryant_div').hide();
                } else if ($(this).val() === 'pavati_number_nusar') {
                    $('#pavati_number_pasun_div').show();
                    $('#pavati_number_paryant_div').show();
                    $('#jama_date_pasun_div').hide();
                    $('#jama_date_paryant_div').hide();
                    $('#book_number_div').show();
                }
            });

            // Handle form submission for PDF generation
            $('form').submit(function (e) {
                e.preventDefault();

                // Get form values
                const bill_type = $('input[name="bill_type"]:checked').val();
                const financial_year = $('#financial_year').val();
                const plan_name = $('#plan_name').val();
                const book_number = $('#book_number').val();
                const pavati_number_pasun = $('#pavati_number_pasun').val();
                const pavati_number_paryant = $('#pavati_number_paryant').val();
                const jama_date_pasun = $('#jama_date_pasun').val();
                const jama_date_paryant = $('#jama_date_paryant').val();

                // Validate required fields
                if (!financial_year) {
                    alert('कृपया आर्थिक वर्ष निवडा');
                    return;
                }

                if (!plan_name) {
                    alert('कृपया फंडाचे नाव निवडा');
                    return;
                }

                // Build URL with parameters
                let url =
                    `pdf/namuna7_pavti_report.php?financial_year=${financial_year}&plan_name=${plan_name}&bill_type=${bill_type}`;

                if (book_number) url += `&book_number=${book_number}`;
                if (pavati_number_pasun) url += `&pavati_number_pasun=${pavati_number_pasun}`;
                if (pavati_number_paryant) url += `&pavati_number_paryant=${pavati_number_paryant}`;
                if (jama_date_pasun) url += `&jama_date_pasun=${jama_date_pasun}`;
                if (jama_date_paryant) url += `&jama_date_paryant=${jama_date_paryant}`;

                // Open in new window for printing
                const printWindow = window.open(url, '_blank');
            });
        });
    </script>
</body>

</html>