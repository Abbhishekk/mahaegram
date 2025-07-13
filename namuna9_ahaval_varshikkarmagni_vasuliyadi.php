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
if (mysqli_num_rows($periods) == 0) {
    $_SESSION['message'] = "आर्थिक वर्ष उपलब्ध नाही.";
    $_SESSION['message_type'] = "danger";
}
$financialYears = $fun->getYearArray($periods);
$periods = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
// print_r($periods);
$periodId = $periods->fetch_assoc()['id'];
// print_r($periodId);
$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);
$property_verifications = $fun->getTaxDemands($_SESSION['district_code']);
$wards = $fun->getWard($_SESSION['district_code']);

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
        include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->

                <div class="container-fluid border rounded p-3">
                    <div class="d-sm-flex align-items-center  justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">वार्षिक कर मागणी व वसुली यादी </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वार्षिक कर मागणी व वसुली यादी</li>
                        </ol>
                    </div>
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
                    <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">रजिस्टर तपशील</h6>
                    </div>
                    <div class="card-body">
                        <form id="pdfForm">
                            // <?php
                            // if (isset($_SESSION['message'])) {
                            //     echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                            //     unset($_SESSION['message']);
                            //     unset($_SESSION['message_type']);
                            // }
                            // ?>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex flex-wrap justify-content-center gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="criteria1" id="milkat_criteria" value="milkat" checked>
                                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="milkat_criteria">
                                                <i class="fas fa-list-ol me-2"></i>मिळकत क्रमांकानुसार
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="criteria1" id="ekat_criteria" value="ekat">
                                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="ekat_criteria">
                                                <i class="fas fa-layer-group me-2"></i>एकत्रीकरण
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex flex-wrap justify-content-center gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="criteria" id="all_register" value="all_register" checked>
                                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="all_register">
                                                <i class="fas fa-book me-2"></i>संपूर्ण रजिस्टर
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="criteria" id="gava_mangani" value="gava_mangani">
                                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="gava_mangani">
                                                <i class="fas fa-village me-2"></i>गावानुसार मागणी
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="criteria" id="malmatta_mangani" value="malmatta_mangani">
                                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="malmatta_mangani">
                                                <i class="fas fa-home me-2"></i>मालमत्तेनुसार मागणी
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="row g-3">
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
                                        <select class="form-select border-primary select2-single-placeholder" name="revenue_village" id="revenue_village">
                                            <option value="" selected>--निवडा--</option>
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
                
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select border-primary" name="malmatta_id" id="malmatta_id">
                                            <option value="">--निवडा--</option>
                                            <?php
                                            foreach ($property_verifications as $property) {
                                                if ($property['status'] != 0) continue;
                                                echo "<option value='{$property['malmatta_id']}'>{$property['malmatta_no']}</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="malmatta_id" class="fw-bold">मालमत्ता क्रमांक</label>
                                    </div>
                                </div>
                
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select border-primary" readonly name="kardena_name" id="kardena_name">
                                            <option value="">--निवडा--</option>
                                        </select>
                                        <label for="kardena_name" class="fw-bold">कर देणाऱ्याचे नाव</label>
                                    </div>
                                </div>
                
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-info text-white w-100 py-3">
                                        <i class="fas fa-search me-2"></i>शोधा
                                    </button>
                                </div>
                            </div>
                
                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary px-4 me-3">
                                        <i class="fas fa-check me-2"></i>ठीक
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
            // Initialize Select2 for the revenue village dropdown
            $('#revenue_village').select2({
                placeholder: 'गाव निवडा',
                allowClear: true
            });

            // Initialize Select2 for the malmatta_id dropdown
            $('#malmatta_id').select2({
                placeholder: 'मालमत्ता क्रमांक निवडा',
                allowClear: true
            });

            // Initialize Select2 for the kardena_name dropdown
            $('#kardena_name').select2({
                placeholder: 'कर देणाऱ्याचे नाव निवडा',
                allowClear: true
            });
        });
    </script>
    <script>
        document.getElementById('pdfForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const criteria = $('input[name="criteria"]:checked').val();
            const financial_year = $('#financial_year').val();
            const village_code = $('#revenue_village').val();
            const ward = $('#ward').val();
            const malmatta_id = $('#malmatta_id').val();

            // Validate required fields
            if (!financial_year) {
                alert('कृपया आर्थिक वर्ष निवडा');
                return;
            }

            if (criteria === 'gava_mangani' && !village_code) {
                alert('कृपया गाव निवडा');
                return;
            }

            if (criteria === 'malmatta_mangani' && !malmatta_id) {
                alert('कृपया मालमत्ता क्रमांक निवडा');
                return;
            }
            let url = `pdf/namuna9_demandReport.php?financial_year=${financial_year}&criteria=${criteria}`;

            if (village_code) {
                url += `&revenue_village=${village_code}`;
            }

            if (ward) {
                url += `&ward=${ward}`;
            }

            if (malmatta_id) {
                url += `&malmatta_id=${malmatta_id}`;
            }
            // 👇 Fetch table HTML from your PHP backend
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
                            $('#kardena_name').append('<option value="">--निवडा--</option>');

                            if (data.owner_name) {
                                $('#kardena_name').append(`<option value="${data.owner_name}">${data.owner_name}</option>`);
                            }

                            if (data.occupant_name && data.occupant_name !== data.owner_name) {
                                $('#kardena_name').append(`<option value="${data.occupant_name}">${data.occupant_name}</option>`);
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

        // Show/hide fields based on selected criteria
        $('input[name="criteria"]').change(function() {
            const criteria = $(this).val();



            // Show relevant fields based on criteria
            if (criteria === 'all_register' || criteria === 'ekat_criteria' || criteria === 'milkat_criteria') {
                $('#revenue_village').attr('disabled', true);
                $('#ward').attr('disabled', true);
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);

            } else if (criteria === 'gava_mangani') {
                $('#revenue_village').attr('disabled', false);
                $('#ward').attr('disabled', true);
                $('#malmatta_id').attr('disabled', true);
                $('#kardena_name').attr('disabled', true);

            } else if (criteria === 'malmatta_mangani') {
                $('#malmatta_id').attr('disabled', false);
                $('#kardena_name').attr('disabled', false);
                $('#revenue_village').attr('disabled', true);
                $('#ward').attr('disabled', false);
            }
        });

        // Initialize field visibility
        $('input[name="criteria"]:checked').trigger('change');
    </script>
</body>

</html>