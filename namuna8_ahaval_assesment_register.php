<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "मालमत्ता कर आकारणी";
?>
<?php include('include/header.php'); ?>
<?php
$materials = $fun->getMaterials($_SESSION['district_code']);
$financialYears = $fun->getFinancialYears();
$banks = $fun->getBanks();
$periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
$periodsWithReasons2 = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
$yearArray = $fun->getYearArray($periodsWithReasons2);
$wards = $fun->getWard($_SESSION['district_code']);
$roadDetails = $fun->getRoad($_SESSION['district_code']);

$khasaraNos = $fun->getKhasaraNoFromMalmatta();

$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
        $page = 'namuna8';
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
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">मालमत्ता कर आकारणी</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 10</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता कर आकारणी</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <?php
                                // print_r($_SESSION);
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
                                    <form id="pdfForm">
                                        <input type="hidden" name="material_id" id="material_id" value="">
                                        <div class="row">
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="all_ahaval" name="ahavalType"
                                                        value="संपूर्ण अहवाल" class="custom-control-input">
                                                    <label class="custom-control-label" for="all_ahaval">संपूर्ण अहवाल
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="according_to_ward" name="ahavalType"
                                                        value="वॉर्ड नुसार अहवाल" class="custom-control-input">
                                                    <label class="custom-control-label" for="according_to_ward">वॉर्ड
                                                        नुसार अहवाल</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="according_to_road" name="ahavalType"
                                                        value="रस्त्यानुसार अहवाल" class="custom-control-input">
                                                    <label class="custom-control-label"
                                                        for="according_to_road">रस्त्यानुसार अहवाल
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="according_to_khasara" name="ahavalType"
                                                        value="खसारानुसर अहवाल" class="custom-control-input">
                                                    <label class="custom-control-label"
                                                        for="according_to_khasara">खसारानुसर अहवाल
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-3 my-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="according_to_gav" name="ahavalType"
                                                        value="गावनुसार अहवाल" class="custom-control-input">
                                                    <label class="custom-control-label" for="according_to_gav">गावनुसार
                                                        अहवाल
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-3 my-3 d-none">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="according_to_years" name="ahavalType"
                                                        value="आर्थिक वर्ष नुसार अहवाल" class="custom-control-input">
                                                    <label class="custom-control-label" for="according_to_years">आर्थिक
                                                        वर्ष नुसार अहवाल
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12"></div>
                                            <div class="form-group col-md-4">
                                                <label for="period">कालावधी<span class="text-danger">*</span>
                                                </label>
                                                <select name="period" id="period" class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                    if (mysqli_num_rows($periodsWithReasons) > 0) {
                                                        while ($periodsWithReason = mysqli_fetch_assoc($periodsWithReasons)) {
                                                            echo '<option value="' . $periodsWithReason['id'] . '">' . $periodsWithReason['total_period'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ward_name">वॉर्ड क्रं <span class="text-danger">*</span>
                                                </label>
                                                <select name="ward_name" id="ward_name" class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                    if (mysqli_num_rows($wards) > 0) {
                                                        while ($ward = mysqli_fetch_assoc($wards)) {
                                                            echo '<option value="' . $ward['id'] . '">' . $ward['ward_name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="khasara_no">खसारा क्रं <span class="text-danger">*</span>
                                                </label>
                                                <select name="khasara_no" id="khasara_no" class="form-control select2-single-placeholder">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                    if (mysqli_num_rows($khasaraNos) > 0) {
                                                        while ($ward = mysqli_fetch_assoc($khasaraNos)) {
                                                            echo '<option value="' . $ward['khasara_no'] . '">' . $ward['khasara_no'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="revenue_village">गावाचे नाव<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-control select2-single-placeholder mb-3"
                                                    name="revenue_village" id="revenue_village">
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
                                            <div class="form-group col-md-3">
                                                <label for="road_name">गल्लीचे नाव/ अंतर्गत रस्त्याचे नाव<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="road_name" id="road_name" class="form-control">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                    if (mysqli_num_rows($roadDetails) > 0) {
                                                        while ($roadDetail = mysqli_fetch_assoc($roadDetails)) {
                                                            echo '<option value="' . $roadDetail['id'] . '">' . $roadDetail['road_name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="drainageType">आर्थिक वर्ष <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control mb-3" name="financialYear"
                                                    id="financialYear">
                                                    <option value="" selected>--निवडा--</option>
                                                    <?php
                                                    if (count($yearArray) > 0) {
                                                        foreach ($yearArray as $year) {
                                                            echo '<option value="' . $year . '">' . $year . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>

                                        </div>

                                        <button type="submit" name="add" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
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
        document.addEventListener('DOMContentLoaded', function () {
            const allAhaval = document.getElementById('all_ahaval');
            const wardRadio = document.getElementById('according_to_ward');
            const roadRadio = document.getElementById('according_to_road');
            const yearsRadio = document.getElementById('according_to_years');
            const khasaraRadio = document.getElementById('according_to_khasara');
            const gavRadio = document.getElementById('according_to_gav');

            const periodSelect = document.getElementById('period').closest('.form-group');
            const wardSelect = document.getElementById('ward_name').closest('.form-group');
            const roadSelect = document.getElementById('road_name').closest('.form-group');
            const yearSelect = document.getElementById('financialYear').closest('.form-group');
            const khasaraSelect = document.getElementById('khasara_no').closest('.form-group');
            const gavSelect = document.getElementById('revenue_village').closest('.form-group');

            function updateVisibility() {
                if (allAhaval.checked) {
                    periodSelect.style.display = 'block';
                    wardSelect.style.display = 'none';
                    roadSelect.style.display = 'none';
                    yearSelect.style.display = 'none';
                    khasaraSelect.style.display = 'none';
                    gavSelect.style.display = 'none';

                } else if (khasaraRadio.checked) {
                    periodSelect.style.display = 'block';
                    wardSelect.style.display = 'none';
                    roadSelect.style.display = 'none';
                    yearSelect.style.display = 'none';
                    khasaraSelect.style.display = 'block';
                    gavSelect.style.display = 'none';

                } else if (gavRadio.checked) {
                    periodSelect.style.display = 'block';
                    wardSelect.style.display = 'none';
                    roadSelect.style.display = 'none';
                    yearSelect.style.display = 'none';
                    khasaraSelect.style.display = 'none';
                    gavSelect.style.display = 'block';

                } else if (wardRadio.checked) {
                    periodSelect.style.display = 'block';
                    wardSelect.style.display = 'block';
                    roadSelect.style.display = 'none';
                    yearSelect.style.display = 'none';
                    khasaraSelect.style.display = 'none';
                    gavSelect.style.display = 'none';

                } else if (roadRadio.checked) {
                    periodSelect.style.display = 'block';
                    wardSelect.style.display = 'none';
                    roadSelect.style.display = 'block';
                    yearSelect.style.display = 'none';
                    khasaraSelect.style.display = 'none';
                    gavSelect.style.display = 'none';
                } else if (yearsRadio.checked) {
                    periodSelect.style.display = 'block';
                    wardSelect.style.display = 'none';
                    roadSelect.style.display = 'none';
                    yearSelect.style.display = 'block';
                    khasaraSelect.style.display = 'none';
                    gavSelect.style.display = 'none';
                } else {
                    // Default: hide all optional selects
                    periodSelect.style.display = 'none';
                    wardSelect.style.display = 'none';
                    roadSelect.style.display = 'none';
                    yearSelect.style.display = 'none';
                    khasaraSelect.style.display = 'none';
                    gavSelect.style.display = 'none';
                }
            }

            // Attach event listeners
            [allAhaval, wardRadio, roadRadio, yearsRadio, gavRadio, khasaraRadio].forEach(radio => {
                radio.addEventListener('change', updateVisibility);
            });

            // Initial visibility
            updateVisibility();
        });
    </script>

    <script>
        document.getElementById('pdfForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const period = document.getElementById('period').value;
            const ward = document.getElementById('ward_name').value;
            const road = document.getElementById('road_name').value;
            const year = document.getElementById('financialYear').value;
            const khasara_no = document.getElementById('khasara_no').value;
            const village = document.getElementById('revenue_village').value;
            const ahavalType = document.querySelector('input[name="ahavalType"]:checked').value;

            // 👇 Fetch table HTML from your PHP backend
            const res = await fetch(
                `pdf/tax_report_template.php?period=${period}&ward=${ward}&road=${road}&year=${year}&type=${ahavalType}&khasara_no=${khasara_no}&village=${village}`, {
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

</body>

</html>