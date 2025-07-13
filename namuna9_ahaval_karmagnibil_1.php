<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "मालमत्ता माहिती प्रमाणिकरण";
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
$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);
$property_verifications = $fun->getTaxDemands($_SESSION['district_code']);
$wards = $fun->getWard($_SESSION['district_code']);
$roads = $fun->getRoad($_SESSION['district_code']);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna9';
        $subpage = 'ahaval';
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
        include('include/sidebar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid border rounded p-3">
                    <div class="bg-light p-2 mb-3 border-bottom">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">कर मागणी बिल</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                                <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                                <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                                <li class="breadcrumb-item active" aria-current="page">कर मागणी बिल</li>
                            </ol>
                        </div>
                        <p class="text-primary small m-0">
                            टीप:- नमुना १/पाणपट्टी रजिस्टर/किरकोळ मागणी पूर्ण तयार केले नंतरच मागणी बिल तयार करावे.
                            कर मागणी बिल तयार करताना कर मागणी बिलाची तारीख खाली करून निवडावी कारण कर मागणी बिल तयार
                            केल्यानंतर तारीख बदलता येत नाही
                        </p>
                    </div>

                    <div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">कर मागणी बिल</h6>
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
                            <input class="form-check-input" type="radio" name="bill_area" id="gramnidhi" checked>
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="gramnidhi">
                                <i class="fas fa-rupee-sign me-2"></i>ग्रामनिधी
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_area" id="panipuratha" disabled>
                            <label class="form-check-label fw-bold btn btn-outline-secondary py-2 px-4 rounded-pill" for="panipuratha">
                                <i class="fas fa-tint me-2"></i>ग्राम पाणीपुरवठा निधी
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_area" id="kirokul" disabled>
                            <label class="form-check-label fw-bold btn btn-outline-secondary py-2 px-4 rounded-pill" for="kirokul">
                                <i class="fas fa-store me-2"></i>किरकोळ मागणी
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_type" id="all_bill" value="all_bill" checked>
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="all_bill">
                                <i class="fas fa-list me-2"></i>संपूर्ण बिल
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_type" id="individual_bill" value="individual_bill">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="individual_bill">
                                <i class="fas fa-user me-2"></i>वैयक्तिक बिल
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_type" id="ward_wise" value="ward_wise">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="ward_wise">
                                <i class="fas fa-map-marker-alt me-2"></i>वार्ड नुसार
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_type" id="road_wise" value="road_wise">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="road_wise">
                                <i class="fas fa-road me-2"></i>रस्त्या नुसार
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary select2-single-placeholder" name="revenue_village" id="revenue_village">
                            <option value="">--निवडा--</option>
                            <?php
                            if (mysqli_num_rows($lgdVillages) > 0) {
                                while ($village = mysqli_fetch_assoc($lgdVillages)) {
                                    echo "<option value='" . $village['Village_Code'] . "'>" . $village['Village_Name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <label for="revenue_village" class="fw-bold">गावाचे नाव <span class="text-danger">*</span></label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="financial_year" id="financial_year">
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
                        <input type="date" class="form-control border-primary" name="date" id="date" value="2025-05-22">
                        <label for="date" class="fw-bold">दिनांक <span class="text-danger">*</span></label>
                    </div>
                </div>

                <div class="col-md-4" id="ward_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="ward" id="ward">
                            <option value="">--निवडा--</option>
                            <?php
                            while ($ward = mysqli_fetch_assoc($wards)) {
                                echo "<option value='{$ward['ward_name']}'>{$ward['ward_name']}</option>";
                            }
                            ?>
                        </select>
                        <label for="ward" class="fw-bold">वॉर्ड नाव</label>
                    </div>
                </div>

                <div class="col-md-4" id="road_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="road" id="road">
                            <option value="">--निवडा--</option>
                            <?php
                            while ($road = mysqli_fetch_assoc($roads)) {
                                echo "<option value='{$road['id']}'>{$road['road_name']}</option>";
                            }
                            ?>
                        </select>
                        <label for="road" class="fw-bold">रस्त्याचे नाव</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="malmatta_id" id="malmatta_id">
                            <option value="">--निवडा--</option>
                            <?php
                            foreach ($property_verifications as $property) {
                                echo "<option value='{$property['malmatta_id']}'>{$property['malmatta_no']}</option>";
                            }
                            ?>
                        </select>
                        <label for="malmatta_id" class="fw-bold">मालमत्ता क्रमांक</label>
                    </div>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-primary w-100 py-3">
                        <i class="fas fa-search me-2"></i>शोधा
                    </button>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" readonly name="kardena_name" id="kardena_name">
                            <option value="">--निवडा--</option>
                        </select>
                        <label for="kardena_name" class="fw-bold">कर देणाऱ्याचे नाव</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="file" class="form-control border-primary" id="sarpanch_sign">
                        <label for="sarpanch_sign" class="fw-bold">सरपंच सही</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="file" class="form-control border-primary" id="gramsevak_sign">
                        <label for="gramsevak_sign" class="fw-bold">ग्रामसेवक सही</label>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="button" id="generatePdfBtn" class="btn btn-primary px-4 me-3">
                        <i class="fas fa-file-pdf me-2"></i>कर मागणी बिल तयार करणे
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
    </script>
    <script>
        $(document).ready(function() {
            console.log("Document is ready");

            $('#generatePdfBtn').click(async function() {
                // Get form values
                console.log("Generate PDF button clicked");

                const revenue_village = $('#revenue_village').val();
                const financial_year = $('#financial_year').val();
                const ward = $('#ward').val() || null;
                const malmatta_id = $('#malmatta_id').val() || null;
                const road = $('#road').val() || null;
                const bill_area = $('input[name="bill_area"]:checked').val();
                const bill_type = $('input[name="bill_type"]:checked').val();
                const date = $('#date').val();

                // Validate required fields
                if (!financial_year) {
                    alert('कृपया आर्थिक वर्ष निवडा');
                    return;
                }

                if (!revenue_village) {
                    alert('कृपया गावाचे नाव निवडा');
                    return;
                }

                if (!date) {
                    alert('कृपया दिनांक निवडा');
                    return;
                }

                if (bill_type === "all_bill" && !revenue_village && !financial_year && !date) {
                    alert('कृपया वॉर्ड किंवा मालमत्ता क्रमांक निवडा');
                    return;
                }

                // Construct URL with parameters
                let url =
                    `pdf/allReports.php?financial_year=${financial_year}&revenue_village=${revenue_village}&date=${date}`;

                if (ward) url += `&ward=${ward}`;
                if (malmatta_id) url += `&malmatta_id=${malmatta_id}`;
                if (bill_area) url += `&bill_area=${bill_area}`;
                if (bill_type) url += `&bill_type=${bill_type}`;
                if (road) url += `&road=${road}`;

                // Open in new window for printing
                const res = await fetch(
                    url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                const html = await res.text();

                // 👇 Open in new tab and print
                const printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(`
            <html>
            <head>
            <title>नमुना 9</title>
            
            </head>
            <body onload="window.print()">
            ${html}
            </body>
            </html>
    `);
                printWindow.document.close();
            });

        });
    </script>
    <script>
        $('#malmatta_id').change(function() {
            const malmatta_id = $(this).val();

            if (malmatta_id) {
                $.ajax({
                    url: 'api/get_property_owners.php',
                    type: 'POST',
                    data: {
                        malmattaId: malmatta_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#kardena_name').empty();
                            $('#kardena_name').attr('disabled', true);
                            $('#kardena_name').append('<option value="">--निवडा--</option>');

                            if (data.owner_name) {
                                $('#kardena_name').append(
                                    `<option value="${data.owner_name}" selected>${data.owner_name}</option>`
                                );
                            }


                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                    }
                });
            } else {
                $('#kardena_name').empty();
                $('#kardena_name').append('<option value="">--निवडा--</option>');
            }
        });
        $('#ward').attr('disabled', true);
        $('#malmatta_id').attr('disabled', true);
        $('#kardena_name').attr('disabled', true);
        $('#ward_div').hide();
        $('#road_div').hide();

        // Show/hide fields based on selected criteria
        $('input[name="bill_type"]').change(function() {
            const criteria = $(this).val();



            // Show relevant fields based on criteria
            if (criteria === 'all_bill') {
                $('#ward').attr('disabled', true);
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').hide();

            } else if (criteria === 'individual_bill') {
                $('#malmatta_id').attr('disabled', false);
                $('#kardena_name').attr('disabled', false);
                $('#revenue_village').attr('disabled', false);
                $('#ward').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').hide();

            } else if (criteria === 'ward_wise') {
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#revenue_village').attr('disabled', false);
                $('#ward').attr('disabled', false);
                $('#ward_div').show();
                $('#road_div').hide();
            } else if (criteria === 'road_wise') {
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#revenue_village').attr('disabled', false);
                $('#ward').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').show();
            } else {
                $('#ward').attr('disabled', true);
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);
                $('#ward_div').hide();
                $('#road_div').hide();
            }
        });

        // Initialize field visibility
        $('input[name="criteria"]:checked').trigger('change');
    </script>
</body>

</html>