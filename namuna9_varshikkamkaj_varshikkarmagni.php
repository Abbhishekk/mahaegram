<?php
require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "वार्षिक कर मागणी";
?>
<?php include('include/header.php'); ?>
<?php
$newName = $fun->getNewName();
$periods = $fun->getPeriodDetails($_SESSION['district_code']);
$wards = $fun->getWard($_SESSION['district_code']);
$property_verifications = $fun->getPropertyVerificationsAccordingToPanchayat();
// print_r($property_verifications);
$period_deatils = $fun->getPeriodDetails($_SESSION['district_code']);
$periodsWithReasons = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी", $_SESSION['district_code']);
$yearArray = $fun->getYearArray($periodsWithReasons);

// Step 1: Determine current financial year
$currentMonth = date('n'); // Numeric representation of current month (1-12)
$currentYear = date('Y');

if ($currentMonth >= 4) {
    // If April or later, financial year starts from current year
    $financialYearStart = $currentYear;
    $financialYearEnd = $currentYear + 1;
} else {
    // If Jan-March, financial year started last year
    $financialYearStart = $currentYear - 1;
    $financialYearEnd = $currentYear;
}

$currentFinancialYear = $financialYearStart . "-" . $financialYearEnd;

// Step 2: Find matching index in the array
$currentYearIndex = 0;
for ($i = 0; $i < count($yearArray); $i++) {
    if ($yearArray[$i] === $currentFinancialYear) {
        $currentYearIndex = $i;
        break;
    }
}

// Debug (optional)
// echo "Current Financial Year: $currentFinancialYear";
// echo "Matched Index: $currentYearIndex";


if (mysqli_num_rows($periods) == 0) {
    $_SESSION['message_type'] = "danger";
    $_SESSION['message'] = "कोणतेही आर्थिक वर्ष उपलब्ध नाही.";
} else if (mysqli_num_rows($wards) == 0) {
    $_SESSION['message_type'] = "danger";
    $_SESSION['message'] = "कोणतेही वॉर्ड उपलब्ध नाही.";
}
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
                <div class="container-fluid border rounded p-1 p-5">
                    <!-- <h5 class="fw-bold text-secondary mb-3">वार्षिक कर मागणी</h5> -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">वार्षिक कर मागणी </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वार्षिक कर मागणी</li>
                        </ol>
                    </div>
                    <!-- मालमत्ता धारकाची माहिती -->
                    <div class="card">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                        }
                        ?>
                        <div class="border card-body rounded p-3 mb-3">
                            <h6 class="fw-bold">मालमत्ता धारकाची माहिती</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="ward">वॉर्ड क्र</label>
                                    <select class="form-select form-control" name="ward" id="ward">
                                        <option>निवडा</option>
                                        <?php
                                        while ($ward = mysqli_fetch_assoc($wards)) {
                                            echo "<option value='{$ward['ward_name']}'>{$ward['ward_name']}</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="malmatta_id">मालमत्ता क्रमांक</label>
                                    <select class="form-select form-control select2-single-placeholder" name="malmatta_id" id="malmatta_id">
                                        <option>--निवडा--</option>
                                        <?php
                                        foreach ($property_verifications as $property) {
                                            if ($property['status'] != 0) continue; // Skip if malmatta_id is 0
                                            echo "<option value='{$property['malmatta_id']}'>{$property['malmatta_no']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button class="btn btn-primary w-100" name="find" id="find">शोधा</button>
                                </div>

                            </div>
                            <div class="border rounded p-3 mb-3">

                                <div class="row mb-3">
                                    <input type="hidden" name="financial_year" id="financial_year" class="form-control"
                                        value="<?php echo $yearArray[$currentYearIndex ?? 0] ?? '';  ?>">
                                    <div class="col-md-6">
                                        <label class="form-label" for="kardena_name">कर देणाऱ्याचे नाव</label>
                                        <select class="form-select form-control" readonly name="kardena_name"
                                            id="kardena_name">
                                            <option>--निवडा--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label class="form-label" for="bhogavata_dharak_name">भोगवटा धारकाचे नाव</label>
                                        <select class="form-select form-control" readonly name="bhogavata_dharak_name"
                                            id="bhogavata_dharak_name">
                                            <option>--निवडा--</option>
                                        </select>
                                    </div>
                                </div>
                                <h6 class="fw-bold">मालमत्तेचे वर्णन </h6>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="ward_name">वॉर्ड क्रं</label>
                                        <select class="form-select  form-control" readonly name="ward_name"
                                            id="ward_name">
                                            <option>निवडा</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="malmatta_no">मालमत्ता क्रमांक</label>
                                        <select class="form-select  form-control" readonly name="malmatta_no"
                                            id="malmatta_no">
                                            <option>--निवडा--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="malmatta_dharak_name">मालमत्ता धारकाचे
                                            नाव</label>
                                        <select class="form-select form-control" readonly name="malmatta_dharak_name"
                                            id="malmatta_dharak_name">
                                            <option>--निवडा--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- कर टॅक्स कार्ड्स -->
                            <div class="row gy-3">
                                <!-- Each box is styled as a card -->
                                <div class="col-md-3 mb-2">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">इमारतीवरील कर</h6>
                                        <label>मागील बाकी <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control mb-1" name="imarativariil_magil_kar"
                                            id="imarativariil_magil_kar">
                                        <label>चालू कर</label>
                                        <input type="text" class="form-control mb-1" readonly
                                            name="imarativariil_chalu_kar" id="imarativariil_chalu_kar">
                                        <label>एकूण रक्कम</label>
                                        <input type="text" class="form-control" readonly
                                            name="imarativariil_ekun_rakkam" id="imarativariil_ekun_rakkam">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">दिवाबत्ती कर</h6>
                                        <label>मागील बाकी <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control mb-1" name="divabatti_kar_magil_baki"
                                            id="divabatti_kar_magil_baki">
                                        <label>चालू कर</label>
                                        <input type="text" class="form-control mb-1" readonly
                                            name="divabatti_kar_chalu_kar" id="divabatti_kar_chalu_kar">
                                        <label>एकूण रक्कम</label>
                                        <input type="text" class="form-control" readonly
                                            name="divabatti_kar_ekun_rakkam" id="divabatti_kar_ekun_rakkam">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">आरोग्य कर </h6>
                                        <label>मागील बाकी</label>
                                        <input type="text" class="form-control mb-1" name="arogya_kar_magil_baki"
                                            id="arogya_kar_magil_baki">
                                        <label>चालू कर</label>
                                        <input type="text" class="form-control mb-1" readonly
                                            name="arogya_kar_chalu_kar" id="arogya_kar_chalu_kar">
                                        <label>एकूण रक्कम</label>
                                        <input type="text" class="form-control" readonly name="arogya_kar_ekun_rakkam"
                                            id="arogya_kar_ekun_rakkam">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">सफाई कर </h6>
                                        <label>मागील बाकी</label>
                                        <input type="text" class="form-control mb-1" name="safai_kar_magil_baki"
                                            id="safai_kar_magil_baki">
                                        <label>चालू कर</label>
                                        <input type="text" class="form-control mb-1" readonly
                                            name="safai_kar_chalu_kar" id="safai_kar_chalu_kar">
                                        <label>एकूण रक्कम</label>
                                        <input type="text" class="form-control" readonly name="safai_kar_ekun_rakkam"
                                            id="safai_kar_ekun_rakkam">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">सार्वजनिक पाणीपट्टी</h6>
                                        <label>मागील बाकी <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control mb-1"
                                            name="sarvajanik_panipatty_magil_baki" id="sarvajanik_panipatty_magil_baki">
                                        <label>चालू कर</label>
                                        <input type="text" class="form-control mb-1" readonly
                                            name="sarvajanik_panipatty_chalu_kar" id="sarvajanik_panipatty_chalu_kar">
                                        <label>एकूण रक्कम</label>
                                        <input type="text" class="form-control" readonly
                                            name="sarvajanik_panipatty_ekun_rakkam"
                                            id="sarvajanik_panipatty_ekun_rakkam">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">पडसर कर</h6>
                                        <label>मागील बाकी <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control mb-1" name="padsar_kar_magil_baki"
                                            id="padsar_kar_magil_baki">
                                        <label>चालू कर</label>
                                        <input type="text" class="form-control mb-1" readonly
                                            name="padsar_kar_chalu_kar" id="padsar_kar_chalu_kar">
                                        <label>एकूण रक्कम</label>
                                        <input type="text" class="form-control" readonly name="padsar_kar_ekun_rakkam"
                                            id="padsar_kar_ekun_rakkam">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">दंड</h6>
                                        <label>दंड मागील</label>
                                        <input type="text" class="form-control mb-1" name="dand_magil_baki"
                                            id="dand_magil_baki">
                                        <label>दंड चालू</label>
                                        <input type="text" class="form-control mb-1" readonly name="dand_chalu_kar"
                                            id="dand_chalu_kar">
                                        <label>दंड एकूण</label>
                                        <input type="text" class="form-control" readonly name="dand_ekun_rakkam"
                                            id="dand_ekun_rakkam">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">नोटीस-सूट (-)रक्कम</h6>
                                        <label>नोटीस फी</label>
                                        <input type="text" class="form-control mb-1" readonly name="notis_fee"
                                            id="notis_fee">
                                        <label>सूट रक्कम</label>
                                        <input type="text" class="form-control mb-1" readonly name="suit_rakkam"
                                            id="suit_rakkam">

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="p-3 shadow-sm bg-white rounded">
                                        <h6 class="text-primary fw-bold">एकूण</h6>
                                        <label>एकूण मागील बाकी</label>
                                        <input type="text" class="form-control mb-1" readonly name="ekun_magil_baki"
                                            id="ekun_magil_baki">
                                        <label>एकूण चालू कर</label>
                                        <input type="text" class="form-control mb-1" readonly name="ekun_chalu_kar"
                                            id="ekun_chalu_kar">
                                        <label>एकूण रक्कम</label>
                                        <input type="text" class="form-control" readonly name="ekun_rakkam"
                                            id="ekun_rakkam">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 text-end">
                                <button class="btn btn-success" name="confirm" id="confirm">साठवा</button>
                                <button class="btn btn-secondary" name="reset" id="reset">रद्द करा</button>
                                <button class="btn btn-primary" name="kar_magna" id="kar_magna">कर मागणी</button>
                            </div>
                            <div class="container-fluid mt-4">

                                <!-- इतर मिळकतीची माहिती -->
                                <h6 class="fw-bold">इतर मिळकतीची माहिती</h6>
                                <div class="table-responsive mb-3">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>मू. क्रमांक</th>
                                                <th>वॉर्ड. क्र.</th>
                                                <th>मू. क्रमांक</th>
                                                <th>कर धारकाचे नाव</th>
                                                <th>आर्थिक वर्ष</th>
                                                <th>इमारतीवरील कर</th>
                                                <th>दिवाबत्ती कर</th>
                                                <th>आरोग्य कर</th>
                                                <th>सार्वजनिक पाणीपट्टी</th>
                                                <th>सफाई कर</th>
                                                <th>पडसर कर</th>
                                                <th>दंड</th>
                                                <th>नोटीस-सूट (-)रक्कम</th>
                                                <th>एकूण</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="20" class="text-center">No records to display.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tax Input Form -->
                                <div class="row g-2 mb-4">
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="imarat_kar" id="imarat_kar"
                                            placeholder="इमारत कर">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="divabatti_kar" id="divabatti_kar"
                                            placeholder="दिवाबत्ती कर">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="safai_kar" id="safai_kar"
                                            placeholder="सफाई कर">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="arogy_kar" id="arogy_kar"
                                            placeholder="आरोग्य कर">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="samany_panni" id="samany_panni"
                                            placeholder="सामान्य पाणीपट्टी">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="padsar_kar" id="padsar_kar"
                                            placeholder="पडसर/खुली जागा">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="dand_rakkam" id="dand_rakkam"
                                            placeholder="दंड रक्कम">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="notis_fi" id="notis_fi"
                                            placeholder="नोटीस फी">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="sut_rakkam" id="sut_rakkam"
                                            placeholder="सूट रक्कम">
                                    </div>
                                    <div class="col-md-2 m-2">
                                        <input type="text" class="form-control" name="ekun_rakkam_new"
                                            id="ekun_rakkam_new" readonly placeholder="एकूण देय रक्कम">
                                    </div>
                                </div>
                                <div class="container text-center my-4">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button class="btn btn-primary mr-3" name="save" id="save"
                                            type="submit">साठवा</button>
                                        <button class="btn btn-secondary" name="reset" id="reset" type="reset">रद्द
                                            करा</button>
                                    </div>
                                </div>


                                <!-- वार्षिक कर मागणी यादी -->
                                <h6 class="fw-bold">वार्षिक कर मागणी यादी</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>मू. क्रमांक</th>
                                                <th>वॉर्ड. क्र.</th>
                                                <th>मू. क्रमांक</th>
                                                <th>कर धारकाचे नाव</th>
                                                <th>आर्थिक वर्ष</th>
                                                <th>इमारतीवरील कर</th>
                                                <th>दिवाबत्ती कर</th>
                                                <th>आरोग्य कर</th>
                                                <th>सार्वजनिक पाणीपट्टी</th>
                                                <th>सफाई कर</th>
                                                <th>पडसर कर</th>
                                                <th>दंड</th>
                                                <th>नोटीस-सूट (-)रक्कम</th>
                                                <th>एकूण</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tax_demands = $fun->getTaxDemands($_SESSION['district_code']);
                                            if (mysqli_num_rows($tax_demands) > 0) {
                                                $count = 1;
                                                while ($row = mysqli_fetch_assoc($tax_demands)) {
                                                    // print_r($row);
                                                    echo "<tr>
                                                                <td>{$count}</td>
                                                                <td>{$row['malmatta_id']}</td>
                                                                <td>{$row['ward_no']}</td>
                                                                <td>{$row['malmatta_no']}</td>
                                                                <td>{$row['owner_name']}</td>
                                                                <td>{$row['financial_year']}</td>
                                                                <td>{$row['building_tax']}</td>
                                                                <td>{$row['light_tax']}</td>
                                                                <td>{$row['health_tax']}</td>
                                                                <td>{$row['water_tax']}</td>
                                                                <td>{$row['safai_tax']}</td>
                                                                <td>{$row['padsar_tax']}</td>
                                                                <td>{$row['fine']}</td>
                                                                <td>{$row['notice_fee']} - {$row['discount']}</td>
                                                                <td>{$row['total_amount']}</td>
                                                            </tr>";
                                                    $count++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='14' class='text-center'>कोणतेही रेकॉर्ड नाही.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
            document.addEventListener("DOMContentLoaded", function() {
                // Find button click handler
                document.getElementById('find').addEventListener('click', function(e) {
                    e.preventDefault();

                    const ward = document.getElementById('ward').value;
                    const malmatta_id = document.getElementById('malmatta_id').value;

                    if (!ward || !malmatta_id) {
                        alert('Please select both ward and malmatta number');
                        return;
                    }

                    fetch('api/getMalmattaByWardsAndId.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `ward=${encodeURIComponent(ward)}&malmatta_id=${encodeURIComponent(malmatta_id)}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Response:', data);

                            if (data.success) {
                                populateForm(data.data, data.malmatta_no);
                            } else {
                                alert(data.message || 'Error fetching property details');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while fetching data');
                        });
                });

                // Function to populate form with malmatta details
                function populateForm(data, malmatta_no) {
                    // Populate owner and occupier names
                    document.getElementById('kardena_name').innerHTML =
                        `<option value="${data.owner_name}">${data.owner_name}</option>`;

                    document.getElementById('bhogavata_dharak_name').innerHTML =
                        `<option value="${data.occupier_name || data.owner_name}">${data.occupier_name || data.owner_name}</option>`;
                    document.getElementById("ward_name").innerHTML =
                        `<option value="${data.ward_no}">${data.ward_no}</option>`;
                    document.getElementById("malmatta_no").innerHTML =
                        `<option value="${data.malmatta_id}">${malmatta_no.malmatta_no}</option>`;
                    // Populate property description section
                    document.querySelector('#malmatta_dharak_name').innerHTML =
                        `<option value="${data.owner_name}">${data.owner_name}</option>`;

                    // You can populate other fields as needed from the data object
                    // For example, if you have previous tax amounts in the data:
                    if (data.previous_taxes) {
                        document.getElementById('imarativariil_magil_kar').value = data.previous_taxes.building ||
                            '0';
                        document.getElementById('divabatti_kar_magil_baki').value = data.previous_taxes.light ||
                            '0';
                        document.getElementById('arogya_kar_magil_baki').value = data.previous_taxes.health || '0';
                        document.getElementById('safai_kar_magil_baki').value = data.previous_taxes.safai || '0';
                        document.getElementById('sarvajanik_panipatty_magil_baki').value = data.previous_taxes
                            .water || '0';
                        document.getElementById('padsar_kar_magil_baki').value = data.previous_taxes.padsar || '0';
                        document.getElementById('dand_magil_baki').value = (data.previous_taxes.building * 0.05)
                            .toFixed(2) || '0';
                    }
                    // Populate current tax amounts if available
                    if (data) {
                        document.getElementById('imarativariil_chalu_kar').value = data.building_tax ||
                            '0';
                        document.getElementById('divabatti_kar_chalu_kar').value = data.light_tax || '0';
                        document.getElementById('arogya_kar_chalu_kar').value = data.health_tax || '0';
                        document.getElementById('safai_kar_chalu_kar').value = data.safai_tax || '0';
                        document.getElementById('sarvajanik_panipatty_chalu_kar').value = data.water_tax ||
                            '0';
                        document.getElementById('padsar_kar_chalu_kar').value = data.padsar_tax || '0';
                        document.getElementById('dand_chalu_kar').value = (data.building_tax * 0.05).toFixed(2) ||
                            '0';
                    }

                    // Calculate totals
                    calculateTotals();
                }

                // Function to calculate all totals
                function calculateTotals() {
                    // Building tax
                    const buildingPrev = parseFloat(document.getElementById('imarativariil_magil_kar').value) || 0;
                    const buildingCurrent = parseFloat(document.getElementById('imarativariil_chalu_kar').value) ||
                        0;
                    document.getElementById('imarativariil_ekun_rakkam').value = (buildingPrev + buildingCurrent)
                        .toFixed(2);

                    // Light tax
                    const lightPrev = parseFloat(document.getElementById('divabatti_kar_magil_baki').value) || 0;
                    const lightCurrent = parseFloat(document.getElementById('divabatti_kar_chalu_kar').value) || 0;
                    document.getElementById('divabatti_kar_ekun_rakkam').value = (lightPrev + lightCurrent).toFixed(
                        2);

                    // Health tax
                    const healthPrev = parseFloat(document.getElementById('arogya_kar_magil_baki').value) || 0;
                    const healthCurrent = parseFloat(document.getElementById('arogya_kar_chalu_kar').value) || 0;
                    document.getElementById('arogya_kar_ekun_rakkam').value = (healthPrev + healthCurrent).toFixed(
                        2);

                    // Health tax
                    const safaiPrev = parseFloat(document.getElementById('safai_kar_magil_baki').value) || 0;
                    const safaiCurrent = parseFloat(document.getElementById('safai_kar_chalu_kar').value) || 0;
                    document.getElementById('safai_kar_ekun_rakkam').value = (safaiPrev + safaiCurrent).toFixed(
                        2);

                    // Water tax
                    const waterPrev = parseFloat(document.getElementById('sarvajanik_panipatty_magil_baki')
                        .value) || 0;
                    const waterCurrent = parseFloat(document.getElementById('sarvajanik_panipatty_chalu_kar')
                        .value) || 0;
                    document.getElementById('sarvajanik_panipatty_ekun_rakkam').value = (waterPrev + waterCurrent)
                        .toFixed(2);

                    // Padsar tax
                    const padsarPrev = parseFloat(document.getElementById('padsar_kar_magil_baki').value) || 0;
                    const padsarCurrent = parseFloat(document.getElementById('padsar_kar_chalu_kar').value) || 0;
                    document.getElementById('padsar_kar_ekun_rakkam').value = (padsarPrev + padsarCurrent).toFixed(
                        2);

                    // Fine
                    const finePrev = parseFloat(document.getElementById('dand_magil_baki').value) || 0;
                    const fineCurrent = parseFloat(document.getElementById('dand_chalu_kar').value) || 0;
                    document.getElementById('dand_ekun_rakkam').value = (finePrev + fineCurrent).toFixed(2);

                    // Notice fee and discount
                    const noticeFee = parseFloat(document.getElementById('notis_fee').value) || 0;
                    const discount = parseFloat(document.getElementById('suit_rakkam').value) || 0;

                    // Calculate grand totals
                    const totalPrev = buildingPrev + lightPrev + healthPrev + waterPrev + padsarPrev + finePrev + safaiPrev;
                    const totalCurrent = buildingCurrent + lightCurrent + healthCurrent + waterCurrent + safaiCurrent +
                        padsarCurrent + fineCurrent;
                    const totalAmount = totalPrev + totalCurrent - discount;

                    document.getElementById('ekun_magil_baki').value = totalPrev.toFixed(2);
                    document.getElementById('ekun_chalu_kar').value = totalCurrent.toFixed(2);
                    document.getElementById('ekun_rakkam').value = totalAmount.toFixed(2);
                }

                $("#imarativariil_magil_kar").on('input', function() {

                    $("#dand_magil_baki").val((parseFloat(this.value) * 0.05).toFixed(2));
                });
                // Add event listeners to all tax inputs to recalculate totals when changed
                const taxInputs = document.querySelectorAll(
                    'input[id$="_magil_baki"], input[id$="_chalu_kar"], input[id$="_rakkam"], #notis_fee, #suit_rakkam'
                );
                taxInputs.forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });

                // Confirm button click handler - show data in confirmation table
                document.getElementById('confirm').addEventListener('click', function(e) {
                    e.preventDefault();

                    // Get all values from the form
                    const formData = {
                        ward: document.getElementById('ward').value,
                        malmatta_id: document.getElementById('malmatta_id').value,
                        owner_name: document.getElementById('kardena_name').value,
                        occupier_name: document.getElementById('bhogavata_dharak_name').value,
                        financial_year: document.getElementById('financial_year').value,
                        building_tax: {
                            previous: document.getElementById('imarativariil_magil_kar').value,
                            current: document.getElementById('imarativariil_chalu_kar').value,
                            total: document.getElementById('imarativariil_ekun_rakkam').value
                        },
                        light_tax: {
                            previous: document.getElementById('divabatti_kar_magil_baki').value,
                            current: document.getElementById('divabatti_kar_chalu_kar').value,
                            total: document.getElementById('divabatti_kar_ekun_rakkam').value
                        },
                        health_tax: {
                            previous: document.getElementById('arogya_kar_magil_baki').value,
                            current: document.getElementById('arogya_kar_chalu_kar').value,
                            total: document.getElementById('arogya_kar_ekun_rakkam').value
                        },
                        safai_tax: {
                            previous: document.getElementById('safai_kar_magil_baki').value,
                            current: document.getElementById('safai_kar_chalu_kar').value,
                            total: document.getElementById('safai_kar_ekun_rakkam').value
                        },
                        water_tax: {
                            previous: document.getElementById('sarvajanik_panipatty_magil_baki').value,
                            current: document.getElementById('sarvajanik_panipatty_chalu_kar').value,
                            total: document.getElementById('sarvajanik_panipatty_ekun_rakkam').value
                        },
                        padsar_tax: {
                            previous: document.getElementById('padsar_kar_magil_baki').value,
                            current: document.getElementById('padsar_kar_chalu_kar').value,
                            total: document.getElementById('padsar_kar_ekun_rakkam').value
                        },
                        fine: {
                            previous: document.getElementById('dand_magil_baki').value,
                            current: document.getElementById('dand_chalu_kar').value,
                            total: document.getElementById('dand_ekun_rakkam').value
                        },
                        notice_fee: document.getElementById('notis_fee').value,
                        discount: document.getElementById('suit_rakkam').value,
                        grand_total: document.getElementById('ekun_rakkam').value
                    };

                    // Populate the confirmation table
                    const tbody = document.querySelector('.table-responsive tbody');
                    tbody.innerHTML = `
            <tr>
                <td>1</td>
                <td>${formData.malmatta_id}</td>
                <td>${formData.ward}</td>
                <td>${formData.malmatta_id}</td>
                <td>${formData.owner_name}</td>
                <td>${formData.financial_year}</td>
                <td>${formData.building_tax.total}</td>
                <td>${formData.light_tax.total}</td>
                <td>${formData.health_tax.total}</td>
                <td>${formData.water_tax.total}</td>
                <td>${formData.safai_tax.total}</td>
                <td>${formData.padsar_tax.total}</td>
                <td>${formData.fine.total}</td>
                <td>${formData.notice_fee}</td>
                <td>${formData.grand_total}</td>
            </tr>
        `;

                    // Also populate the edit inputs below
                    document.getElementById('imarat_kar').value = formData.building_tax.current;
                    document.getElementById('divabatti_kar').value = formData.light_tax.current;
                    document.getElementById('arogy_kar').value = formData.health_tax.current;
                    document.getElementById('safai_kar').value = formData.safai_tax.current;
                    document.getElementById('samany_panni').value = formData.water_tax.current;
                    document.getElementById('padsar_kar').value = formData.padsar_tax.current;
                    document.getElementById('dand_rakkam').value = formData.fine.current;
                    document.getElementById('notis_fi').value = formData.notice_fee;
                    document.getElementById('sut_rakkam').value = formData.discount;
                    document.getElementById('ekun_rakkam_new').value = formData.grand_total;
                });

                $("#imarat_kar, #divabatti_kar, #safai_tax ,#arogy_kar, #samany_panni, #padsar_kar, #dand_rakkam, #notis_fi, #sut_rakkam, #ekun_rakkam_new")
                    .on('change', function() {
                        console.log("Tax inputs changed");

                        // Recalculate totals when any of the tax inputs change
                        $("#ekun_rakkam_new").val(
                            (parseFloat($("#imarat_kar").val() || 0) +
                                parseFloat($("#divabatti_kar").val() || 0) +
                                parseFloat($("#arogy_kar").val() || 0) +
                                parseFloat($("#safai_kar").val() || 0) +
                                parseFloat($("#samany_panni").val() || 0) +
                                parseFloat($("#padsar_kar").val() || 0) +
                                parseFloat($("#dand_rakkam").val() || 0) -
                                parseFloat($("#sut_rakkam").val() || 0) +
                                parseFloat($("#notis_fi").val() || 0)).toFixed(2)
                        );
                    });


                // Save button click handler - save the final data
                document.getElementById('save').addEventListener('click', function(e) {
                    e.preventDefault();

                    const data = {
                        ward: document.getElementById('ward').value,
                        malmatta_id: document.getElementById('malmatta_id').value,
                        owner_name: document.getElementById('kardena_name').value,
                        financial_year: document.getElementById('financial_year').value,
                        building_tax: document.getElementById('imarat_kar').value || 0,
                        previous_remaining_building_tax: document.getElementById(
                            'imarativariil_magil_kar').value || 0,
                        current_building_tax: document.getElementById('imarativariil_chalu_kar')
                            .value || 0,
                        light_tax: document.getElementById('divabatti_kar').value || 0,
                        previous_remaining_light_tax: document.getElementById(
                            'divabatti_kar_magil_baki').value || 0,
                        current_light_tax: document.getElementById('divabatti_kar_chalu_kar').value ||
                            0,
                        health_tax: document.getElementById('arogy_kar').value || 0,
                        previous_remaining_health_tax: document.getElementById('arogya_kar_magil_baki')
                            .value || 0,
                        current_health_tax: document.getElementById('arogya_kar_chalu_kar').value || 0,
                        safai_tax: document.getElementById('safai_kar').value || 0,
                        previous_remaining_safai_tax: document.getElementById('safai_kar_magil_baki')
                            .value || 0,
                        current_safai_tax: document.getElementById('safai_kar_chalu_kar').value || 0,
                        water_tax: document.getElementById('samany_panni').value || 0,
                        previous_remaining_water_tax: document.getElementById(
                            'sarvajanik_panipatty_magil_baki').value || 0,
                        current_water_tax: document.getElementById('sarvajanik_panipatty_chalu_kar')
                            .value || 0,
                        padsar_tax: document.getElementById('padsar_kar').value || 0,
                        previous_remaining_padsar_tax: document.getElementById('padsar_kar_magil_baki')
                            .value || 0,
                        current_padsar_tax: document.getElementById('padsar_kar_chalu_kar').value || 0,
                        fine: document.getElementById('dand_rakkam').value || 0,
                        previous_remaining_fine: document.getElementById('dand_magil_baki').value || 0,
                        current_fine: document.getElementById('dand_chalu_kar').value || 0,
                        notice_fee: document.getElementById('notis_fi').value || 0,
                        discount: document.getElementById('sut_rakkam').value || 0,
                        total_amount: document.getElementById('ekun_rakkam_new').value || 0,
                        previous_remaining_total: document.getElementById('ekun_magil_baki').value || 0,
                        current_total: document.getElementById('ekun_chalu_kar').value || 0,

                        created_by: '<?php echo $_SESSION['user_id'] ?? 0; ?>'
                    };

                    fetch('api/save_tax_demand.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Tax demand saved successfully!');
                                // Optionally refresh the page or update the UI
                                location.reload();
                            } else {
                                alert(data.message || 'Error saving tax demand');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while saving data');
                        });
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Function to calculate totals for each tax section
                function calculateSectionTotals() {
                    // Building tax section
                    const buildingPrev = parseFloat(document.getElementById('imarativariil_magil_kar').value) || 0;
                    const buildingCurrent = parseFloat(document.getElementById('imarativariil_chalu_kar').value) ||
                        0;
                    const buildingTotal = buildingPrev + buildingCurrent;
                    document.getElementById('imarativariil_ekun_rakkam').value = buildingTotal.toFixed(2);
                    document.getElementById('imarat_kar').value = buildingTotal.toFixed(2);

                    // Light tax section
                    const lightPrev = parseFloat(document.getElementById('divabatti_kar_magil_baki').value) || 0;
                    const lightCurrent = parseFloat(document.getElementById('divabatti_kar_chalu_kar').value) || 0;
                    const lightTotal = lightPrev + lightCurrent;
                    document.getElementById('divabatti_kar_ekun_rakkam').value = lightTotal.toFixed(2);
                    document.getElementById('divabatti_kar').value = lightTotal.toFixed(2);

                    // Health tax section
                    const healthPrev = parseFloat(document.getElementById('arogya_kar_magil_baki').value) || 0;
                    const healthCurrent = parseFloat(document.getElementById('arogya_kar_chalu_kar').value) || 0;
                    const healthTotal = healthPrev + healthCurrent;
                    document.getElementById('arogya_kar_ekun_rakkam').value = healthTotal.toFixed(2);
                    document.getElementById('arogy_kar').value = healthTotal.toFixed(2);

                    // Safai tax section
                    const safaiPrev = parseFloat(document.getElementById('safai_kar_magil_baki').value) || 0;
                    const safaiCurrent = parseFloat(document.getElementById('safai_kar_chalu_kar').value) || 0;
                    const safaiTotal = safaiPrev + safaiCurrent;
                    document.getElementById('safai_kar_ekun_rakkam').value = safaiTotal.toFixed(2);
                    document.getElementById('safai_kar').value = safaiTotal.toFixed(2);

                    // Water tax section
                    const waterPrev = parseFloat(document.getElementById('sarvajanik_panipatty_magil_baki')
                        .value) || 0;
                    const waterCurrent = parseFloat(document.getElementById('sarvajanik_panipatty_chalu_kar')
                        .value) || 0;
                    const waterTotal = waterPrev + waterCurrent;
                    document.getElementById('sarvajanik_panipatty_ekun_rakkam').value = waterTotal.toFixed(2);
                    document.getElementById('samany_panni').value = waterTotal.toFixed(2);

                    // Padsar tax section
                    const padsarPrev = parseFloat(document.getElementById('padsar_kar_magil_baki').value) || 0;
                    const padsarCurrent = parseFloat(document.getElementById('padsar_kar_chalu_kar').value) || 0;
                    const padsarTotal = padsarPrev + padsarCurrent;
                    document.getElementById('padsar_kar_ekun_rakkam').value = padsarTotal.toFixed(2);
                    document.getElementById('padsar_kar').value = padsarTotal.toFixed(2);

                    // Fine section
                    const finePrev = parseFloat(document.getElementById('dand_magil_baki').value) || 0;
                    const fineCurrent = parseFloat(document.getElementById('dand_chalu_kar').value) || 0;
                    const fineTotal = finePrev + fineCurrent;
                    document.getElementById('dand_ekun_rakkam').value = fineTotal.toFixed(2);
                    document.getElementById('dand_rakkam').value = fineTotal.toFixed(2);

                    // Notice fee and discount
                    const noticeFee = parseFloat(document.getElementById('notis_fee').value) || 0;
                    const discount = parseFloat(document.getElementById('suit_rakkam').value) || 0;
                    document.getElementById('notis_fi').value = noticeFee.toFixed(2);
                    document.getElementById('sut_rakkam').value = discount.toFixed(2);

                    // Calculate grand totals
                    const totalPrev = buildingPrev + lightPrev + healthPrev + waterPrev + padsarPrev + finePrev;
                    const totalCurrent = buildingCurrent + lightCurrent + healthCurrent + waterCurrent +
                        padsarCurrent + fineCurrent;
                    const totalAmount = totalPrev + totalCurrent - discount + noticeFee;

                    document.getElementById('ekun_magil_baki').value = totalPrev.toFixed(2);
                    document.getElementById('ekun_chalu_kar').value = totalCurrent.toFixed(2);
                    document.getElementById('ekun_rakkam').value = totalAmount.toFixed(2);
                    document.getElementById('ekun_rakkam_new').value = totalAmount.toFixed(2);
                }

                // Add event listeners to all tax inputs to recalculate when changed
                const taxInputs = [
                    'imarativariil_magil_kar', 'imarativariil_chalu_kar',
                    'divabatti_kar_magil_baki', 'divabatti_kar_chalu_kar',
                    'safai_kar_magil_baki', 'safai_kar_chalu_kar',
                    'arogya_kar_magil_baki', 'arogya_kar_chalu_kar',
                    'sarvajanik_panipatty_magil_baki', 'sarvajanik_panipatty_chalu_kar',
                    'padsar_kar_magil_baki', 'padsar_kar_chalu_kar',
                    'dand_magil_baki', 'dand_chalu_kar',
                    'notis_fee', 'suit_rakkam'
                ];

                taxInputs.forEach(inputId => {
                    document.getElementById(inputId).addEventListener('input', calculateSectionTotals);
                });

                // Also add listeners to the individual tax inputs at the bottom
                const bottomTaxInputs = [
                    'imarat_kar', 'divabatti_kar', 'safai_kar' ,'arogy_kar',
                    'samany_panni', 'padsar_kar', 'dand_rakkam',
                    'notis_fi', 'sut_rakkam'
                ];

                bottomTaxInputs.forEach(inputId => {
                    document.getElementById(inputId).addEventListener('input', function() {
                        // When these inputs change, update the corresponding section totals
                        if (inputId === 'imarat_kar') {
                            document.getElementById('imarativariil_chalu_kar').value = this.value ||
                                '0';
                        } else if (inputId === 'divabatti_kar') {
                            document.getElementById('divabatti_kar_chalu_kar').value = this.value ||
                                '0';
                        } 
                        else if (inputId === 'arogy_kar') {
                            document.getElementById('arogya_kar_chalu_kar').value = this.value ||
                                '0';
                        } 
                        else if (inputId === 'safai_kar') {
                            document.getElementById('safai_kar_chalu_kar').value = this.value ||
                                '0';
                        } 
                        else if (inputId === 'samany_panni') {
                            document.getElementById('sarvajanik_panipatty_chalu_kar').value = this
                                .value || '0';
                        } else if (inputId === 'padsar_kar') {
                            document.getElementById('padsar_kar_chalu_kar').value = this.value ||
                                '0';
                        } else if (inputId === 'dand_rakkam') {
                            document.getElementById('dand_chalu_kar').value = this.value || '0';
                        } else if (inputId === 'notis_fi') {
                            document.getElementById('notis_fee').value = this.value || '0';
                        } else if (inputId === 'sut_rakkam') {
                            document.getElementById('suit_rakkam').value = this.value || '0';
                        }

                        // Recalculate all totals
                        calculateSectionTotals();
                    });
                });

                // Initial calculation when page loads
                calculateSectionTotals();


            });
        </script>
</body>

</html>