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
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); 
                include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid border rounded p-3" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">नमुना नं.७ पावती रजिस्टर</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक ७</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना नं.७ पावती रजिस्टर</li>
                        </ol>
                    </div>
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">रजिस्टर तपशील</h6>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                                
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                                                    <div class="d-flex flex-wrap justify-content-center gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="bill_type" id="all_register" value="all_register" checked>
                                    <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="all_register">
                                        <i class="fas fa-book me-2"></i>संपूर्ण रजिस्टर
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="bill_type" id="book_number_radio" value="book_number">
                                    <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="book_number_radio">
                                        <i class="fas fa-bookmark me-2"></i>बुक नंबर नुसार
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="bill_type" id="jama_dinanknusar" value="jama_dinanknusar">
                                    <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="jama_dinanknusar">
                                        <i class="fas fa-calendar-alt me-2"></i>जमा दिनांकानुसार
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="bill_type" id="pavati_number_nusar" value="pavati_number_nusar">
                                    <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="pavati_number_nusar">
                                        <i class="fas fa-receipt me-2"></i>पावती नंबर नुसार
                                    </label>
                                </div>
                            </div>


                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" name="financial_year" id="financial_year" >
                                                <option value="">--निवडा--</option>
                                                <?php foreach ($financialYears as $year): ?>
                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="financial_year" class="fw-bold">आर्थिक वर्ष</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" name="plan_name" id="plan_name" >
                                                <option value="">--निवडा--</option>
                                                <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                            </select>
                                            <label for="plan_name" class="fw-bold">फंडाचे नाव</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="book_number_div">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" name="book_number" id="book_number">
                                                <option value="">--निवडा--</option>
                                            </select>
                                            <label for="book_number" class="fw-bold">बुक नंबर</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="pavati_number_pasun_div">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" name="pavati_number_pasun" id="pavati_number_pasun">
                                                <option value="">--निवडा--</option>
                                            </select>
                                            <label for="pavati_number_pasun" class="fw-bold">पावती नंबर पासून</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="pavati_number_paryant_div">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" name="pavati_number_paryant" id="pavati_number_paryant">
                                                <option value="">--निवडा--</option>
                                            </select>
                                            <label for="pavati_number_paryant" class="fw-bold">पावती नंबर पर्यत</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="jama_date_pasun_div">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" name="jama_date_pasun" id="jama_date_pasun">
                                                <option value="">--निवडा--</option>
                                            </select>
                                            <label for="jama_date_pasun" class="fw-bold">जमा दिनांक पासून</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="jama_date_paryant_div">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" name="jama_date_paryant" id="jama_date_paryant">
                                                <option value="">--निवडा--</option>
                                            </select>
                                            <label for="jama_date_paryant" class="fw-bold">पर्यत</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary px-4 me-3">
                                            <i class="fas fa-eye me-2"></i>तपशील पहा
                                        </button>
                                        <button type="reset" class="btn btn-outline-danger px-4">
                                            <i class="fas fa-times me-2"></i>रद्द करणे
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    
    <style>
        /* Custom styles that won't affect other components */
        #container-wrapper .form-floating > label {
            font-weight: 500;
            color: #495057;
        }
        #container-wrapper .form-select {
            height: calc(3.5rem + 2px);
        }
        #container-wrapper .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        #container-wrapper .card-header {
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }
    </style>
    
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