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
        include('include/sidebar.php');
        ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid border rounded p-3">
                    <div class="bg-light p-2 mb-3 border-bottom">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">कर मागणी बिल</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
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

                    <form action="">
                        <div class="card p-4">
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                unset($_SESSION['message']);
                                unset($_SESSION['message_type']);
                            }
                            ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_area" class="me-1" checked> ग्रामनिधी</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_area" class="me-1" disabled> ग्राम पाणीपुरवठा निधी</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_area" class="me-1" disabled> किरकोळ मागणी</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="me-3 col-md-3 fw-bold text-secondary" id="all_bill"><input
                                            type="radio" name="bill_type" class="me-1" value="all_bill" id="all_bill"
                                            checked> संपूर्ण बिल</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary" for="individual_bill"><input
                                            type="radio" name="bill_type" value="individual_bill" id="individual_bill"
                                            class="me-1"> वैयक्तिक बिल</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary" for="ward_wise"><input
                                            type="radio" name="bill_type" value="ward_wise" id="ward_wise" class="me-1">
                                        वार्ड नुसार</label>
                                    <label class="fw-bold col-md-2 text-secondary" for="road_wise"><input type="radio"
                                            name="bill_type" class="me-1" value="road_wise" id="road_wise">
                                        रस्त्या नुसार</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-group col-md-4">
                                    <label for="revenue_village">गावाचे नाव<span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2-single-placeholder mb-3" name="revenue_village"
                                        id="revenue_village">
                                        <option value="" selected>--निवडा.--</option>
                                        <?php
                                        if (mysqli_num_rows($lgdVillages) > 0) {
                                            while ($village = mysqli_fetch_assoc($lgdVillages)) {
                                                echo "<option value='" . $village['Village_Code'] . "'>" . $village['Village_Name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-md-6 my-2">
                                    <label class="form-label fw-bold" for="financial_year">आर्थिक वर्ष :</label>
                                    <select class="form-control border-primary" name="financial_year"
                                        id="financial_year">
                                        <option value=""> --निवडा-- </option>
                                        <?php foreach ($financialYears as $year): ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">दिनांक <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" id="date" value="2025-05-22">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 my-2 " id="ward_div">
                                    <label class="form-label" for="ward">वॉर्ड नाव</label>
                                    <select class="form-select form-control" name="ward" id="ward">
                                        <option value="">निवडा</option>
                                        <?php
                                        while ($ward = mysqli_fetch_assoc($wards)) {
                                            echo "<option value='{$ward['ward_name']}'>{$ward['ward_name']}</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 my-2 " id="road_div">
                                    <label class="form-label" for="road">रस्त्याचे नाव</label>
                                    <select class="form-select form-control" name="road" id="road">
                                        <option value="">निवडा</option>
                                        <?php
                                        while ($road = mysqli_fetch_assoc($roads)) {
                                            // print_r($road);
                                            echo "<option value='{$road['id']}'>{$road['road_name']}</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 my-2 ">
                                    <label class="form-label" for="malmatta_id">मालमत्ता क्रमांक</label>
                                    <select class="form-select form-control" name="malmatta_id" id="malmatta_id">
                                        <option value="">--निवडा--</option>
                                        <?php
                                        foreach ($property_verifications as $property) {

                                            echo "<option value='{$property['malmatta_id']}'>{$property['malmatta_no']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button class="btn btn-primary w-100">शोधा</button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3 my-2 ">
                                    <label class="form-label" for="kardena_name">कर देणाऱ्याचे नाव</label>
                                    <select class="form-select form-control" readonly name="kardena_name"
                                        id="kardena_name">
                                        <option>--निवडा--</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">सरपंच सही</label>
                                    <input type="file" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">ग्रामसेवक सही</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 d-flex gap-2 justify-content-start">
                                    <button type="button" id="generatePdfBtn" class="ml-3 btn btn-primary">कर मागणी बिल
                                        तयार करणे</button>
                                    <button class="ml-3 btn btn-secondary">रद्द करणे</button>
                                </div>
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
            <title>नमुना ८</title>
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
        $('#malmatta_id').change(function () {
            const malmatta_id = $(this).val();

            if (malmatta_id) {
                $.ajax({
                    url: 'api/get_property_owners.php',
                    type: 'POST',
                    data: {
                        malmattaId: malmatta_id
                    },
                    dataType: 'json',
                    success: function (data) {
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
                    error: function (xhr, status, error) {
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
        $('input[name="bill_type"]').change(function () {
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