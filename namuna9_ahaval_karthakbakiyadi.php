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

                <div class="container-fluid border rounded p-3" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">कर थकबाकी यादी</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
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
                        <div class=" card row p-4">
                            <div class="col-md-12 mb-3">
                                <label class="me-4 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="bill_type" checked class="me-1"> कर थकबाकी बिल (घरफाळा)
                                </label>
                                <label class="me-4 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="bill_type" disabled class="me-1"> कर थकबाकी बिल
                                    (पाणीपट्टी)
                                </label>
                                <label class="fw-bold col-md-3 text-secondary d-inline-block">
                                    <input type="radio" name="bill_type" disabled class="me-1"> कर थकबाकी बिल (किरकोळ)
                                </label>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="me-3 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="criteria" id="ward_wise" value="ward_wise" class="me-1">
                                    वॉर्ड नुसार
                                </label>
                                <label class="me-3 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="criteria" id="gawana" value="gawana" class="me-1">
                                    गावानुसार
                                </label>
                                <label class="me-3 col-md-3 fw-bold text-secondary d-inline-block me-3">
                                    <input type="radio" name="criteria" id="road_wise" value="road_wise" class="me-1">
                                    रस्त्यानुसार
                                </label>
                                <label class="fw-bold col-md-2 text-secondary d-inline-block">
                                    <input type="radio" name="criteria" id="milkat_criteria" value="milkat_criteria"
                                        class="me-1"> मिळकत क्रमांक अनुसार
                                </label>
                            </div>
                            <div class="row">

                                <div class="col-md-4 my-2" id="financial_year_div">
                                    <label class="form-label fw-bold">आर्थिक वर्ष :</label>
                                    <select class="form-control border-primary" name="financial_year"
                                        id="financial_year">
                                        <option value=""> --निवडा-- </option>
                                        <?php foreach ($financialYears as $year): ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4 my-2 " id="ward_div">
                                    <label class="form-label" for="ward">वॉर्ड नाव</label>
                                    <select class="form-select form-control" name="ward" id="ward">
                                        <option>निवडा</option>
                                        <?php
                                        while ($ward = mysqli_fetch_assoc($wards)) {
                                            echo "<option value='{$ward['id']}'>{$ward['ward_name']}</option>";
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
                                <div class="form-group col-md-4" id="revenue_village_div">
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
                                <div class="col-md-4 my-2 " id="malmatta_id_div">
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
                            </div>

                            <div class="col-md-12 mb-3 d-flex justify-content-center  ">
                                <button type="button" id="generatePdfBtn" class="btn btn-primary me-2 mx-4">तपशील
                                    पहा</button>
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