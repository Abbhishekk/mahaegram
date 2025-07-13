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

                <div class="container-fluid border rounded p-3" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">कर थकबाकी यादी</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">कर थकबाकी यादी</li>
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
                        <div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">कर थकबाकी बिल</h6>
    </div>
    <div class="card-body">
        <form>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_type" id="gharphala" checked>
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="gharphala">
                                <i class="fas fa-home me-2"></i>कर थकबाकी बिल (घरफाळा)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_type" id="panipatti" disabled>
                            <label class="form-check-label fw-bold btn btn-outline-secondary py-2 px-4 rounded-pill" for="panipatti">
                                <i class="fas fa-tint me-2"></i>कर थकबाकी बिल (पाणीपट्टी)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_type" id="kirokul" disabled>
                            <label class="form-check-label fw-bold btn btn-outline-secondary py-2 px-4 rounded-pill" for="kirokul">
                                <i class="fas fa-store me-2"></i>कर थकबाकी बिल (किरकोळ)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="criteria" id="ward_wise" value="ward_wise">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="ward_wise">
                                <i class="fas fa-map-marker-alt me-2"></i>वॉर्ड नुसार
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="criteria" id="gawana" value="gawana">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="gawana">
                                <i class="fas fa-village me-2"></i>गावानुसार
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="criteria" id="road_wise" value="road_wise">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="road_wise">
                                <i class="fas fa-road me-2"></i>रस्त्यानुसार
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="criteria" id="milkat_criteria" value="milkat_criteria">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="milkat_criteria">
                                <i class="fas fa-list-ol me-2"></i>मिळकत क्रमांक अनुसार
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4" id="financial_year_div">
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

                <div class="col-md-4" id="ward_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="ward" id="ward">
                            <option value="">--निवडा--</option>
                            <?php
                            while ($ward = mysqli_fetch_assoc($wards)) {
                                echo "<option value='{$ward['id']}'>{$ward['ward_name']}</option>";
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

                <div class="col-md-4" id="revenue_village_div">
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

                <div class="col-md-4" id="malmatta_id_div">
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
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="button" id="generatePdfBtn" class="btn btn-primary px-4 me-3">
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
    </script>
    <script>
        $(document).ready(function () {
            console.log("Document is ready");

            $('#generatePdfBtn').click(async function () {
                // Get form values
                console.log("Generate PDF button clicked");

                const revenue_village = $('#revenue_village').val();
                const financial_year = $('#financial_year').val();
                const ward = $('#ward').val() || null;
                const malmatta_id = $('#malmatta_id').val() || null;
                const road = $('#road').val() || null;
                const bill_area = $('input[name="bill_area"]:checked').val();
                const criteria = $('input[name="criteria"]:checked').val();
                const date = $('#date').val();

                // Validate required fields
                if (!financial_year) {
                    alert('कृपया आर्थिक वर्ष निवडा');
                    return;
                }


                if (criteria === "ward_wise" && !ward) {
                    alert('कृपया वॉर्ड निवडा');
                    return;
                } else if (criteria === "road_wise" && !road) {
                    alert('कृपया रस्त्याचे नाव निवडा');
                    return;
                } else if (criteria === "milkat_criteria" && !malmatta_id) {
                    alert('कृपया मालमत्ता क्रमांक निवडा');
                    return;
                } else if (criteria === "gawana" && !revenue_village) {
                    alert('कृपया गावाचे नाव निवडा');
                    return;
                }

                // Construct URL with parameters
                let url =
                    `pdf/namuna9_thak_baki.php?financial_year=${financial_year}`;
                if (revenue_village) url += `&revenue_village=${revenue_village}`;
                if (date) url += `&date=${date}`;
                if (ward) url += `&ward=${ward}`;
                if (malmatta_id) url += `&malmatta_id=${malmatta_id}`;
                if (bill_area) url += `&bill_area=${bill_area}`;
                if (criteria) url += `&bill_type=${criteria}`;
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
            <style>
        body {
            font-family: 'Mangal', 'Noto Sans Devanagari', 'Arial', sans-serif;
            margin: 20px;
            color: #000;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .header-note {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        @media print {
            @page {
                size: landscape;
            }
        }
        </style>
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
        // Show/hide fields based on selected criteria
        $("#malmatta_id_div").hide();
        $("#ward_div").hide();
        $("#road_div").hide();
        $("#kardena_name_div").hide();
        $("#revenue_village_div").hide();
        $('input[name="criteria"]').change(function () {
            const criteria = $(this).val();


            console.log("Selected criteria:", criteria);

            // Show relevant fields based on criteria
            if (criteria === 'gawana') {
                $("#malmatta_id_div").hide();
                $("#ward_div").hide();
                $("#road_div").hide();
                $("#kardena_name_div").hide();
                $("#revenue_village_div").show();

            } else if (criteria === 'ward_wise') {
                $("#malmatta_id_div").hide();
                $("#ward_div").show();
                $("#road_div").hide();
                $("#kardena_name_div").hide();
                $("#revenue_village_div").hide();

            } else if (criteria === 'road_wise') {
                $('#ward_div').hide();
                $("#malmatta_id_div").hide();
                $('#road_div').show();
                $('#ward_div').hide();
                $('#revenue_village_div').hide();
            } else if (criteria === 'milkat_criteria') {
                $("#malmatta_id_div").show();
                $("#ward_div").hide();
                $("#road_div").hide();
                $("#kardena_name_div").hide();
                $("#revenue_village_div").hide();
            } else {
                $("#malmatta_id_div").hide();
                $("#ward_div").hide();
                $("#road_div").hide();
                $("#kardena_name_div").hide();
                $("#revenue_village_div").hide();
            }
        });
    </script>
</body>

</html>