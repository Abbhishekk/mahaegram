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
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी",$_SESSION['district_code']);
    $malmatta_propertyVerifications = $fun->getPropertyVerificationsAccordingToPanchayat();
    $drainage_type = $fun->getDrainageTypes();
    $incomeTypes = $fun->getIncomeType();
?>
<style>
.section-title {
    font-weight: bold;
    margin-top: 20px;
    color: blue;
}

.table td,
.table th {
    vertical-align: middle;
    text-align: center;
}

.highlight {
    background-color: #66ff66;
}
</style>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna8';
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
                        <h1 class="h3 mb-0 text-gray-800">मालमत्ता कर आकारणी</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता कर आकारणी</li>
                        </ol>
                    </div>
                    <div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">मालमत्ता कर आकारणी</h6>
    </div>
    <div class="card-body">
        <form action="" id="pdfForm">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option" value="milkat_no" id="milkat_no">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="milkat_no">
                                <i class="fas fa-hashtag me-2"></i>मिळकत नंबर नुसार अहवाल
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="paniwapar" name="option" id="paniwapar">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="paniwapar">
                                <i class="fas fa-tint me-2"></i>पाणीवापर प्रकार नुसार अहवाल
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="washroom_available" name="option" id="washroom_availables">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="washroom_availables">
                                <i class="fas fa-toilet me-2"></i>शौचालय आहे
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option" value="milkat_type" id="milkat_type">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="milkat_type">
                                <i class="fas fa-home me-2"></i>मिळकत प्रकार
                            </label>
                        </div>
                        <div class="form-check d-none">
                            <input class="form-check-input" type="radio" name="option" id="option5">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="option5">
                                <i class="fas fa-exchange-alt me-2"></i>फेरफार नुसार अहवाल
                            </label>
                        </div>
                        <div class="form-check d-none">
                            <input class="form-check-input" type="radio" name="option" id="option6">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="option6">
                                <i class="fas fa-balance-scale me-2"></i>कमी जास्त पत्रक नुसार अहवाल
                            </label>
                        </div>
                        <div class="form-check d-none">
                            <input class="form-check-input" type="radio" name="option" id="option7">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="option7">
                                <i class="fas fa-hand-holding-usd me-2"></i>करातून सूट/करमाफ असणाऱ्या जमिनी व इमारती
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4" id="period_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="period" id="period">
                            <option value="">--निवडा--</option>
                            <?php if(mysqli_num_rows($periods) > 0) {
                                while($period = mysqli_fetch_assoc($periods)) { ?>
                            <option value="<?php echo $period['id']; ?>">
                                <?php echo $period['total_period']; ?>
                            </option>
                            <?php }
                            } ?>
                        </select>
                        <label for="period" class="fw-bold">कालावधी</label>
                    </div>
                </div>

                <div class="col-md-4" id="malmatta_no_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="malmatta_no" id="malmatta_no">
                            <option value="">--निवडा--</option>
                            <?php if(count($malmatta_propertyVerifications) > 0) {
                                foreach($malmatta_propertyVerifications as $property) { ?>
                            <option value="<?php echo $property['malmatta_id']; ?>">
                                <?php echo $property['malmatta_no']; ?>
                            </option>
                            <?php }
                            } ?>
                        </select>
                        <label for="malmatta_no" class="fw-bold">मिळकत नंबर</label>
                    </div>
                </div>

                <div class="col-md-4" id="drainage_type_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="drainage_type" id="drainage_type">
                            <option value="">--निवडा--</option>
                            <?php if(mysqli_num_rows($drainage_type) > 0) {
                                while($type = mysqli_fetch_assoc($drainage_type)) { ?>
                            <option value="<?php echo $type['drainage_type']; ?>">
                                <?php echo $type['drainage_type']; ?>
                            </option>
                            <?php }
                            } ?>
                        </select>
                        <label for="drainage_type" class="fw-bold">पाणीवापर प्रकार</label>
                    </div>
                </div>

                <div class="col-md-4" id="washroom_available_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="washroom_available" id="washroom_available">
                            <option value="">--निवडा--</option>
                            <option value="yes">आहे</option>
                            <option value="no">नाही</option>
                        </select>
                        <label for="washroom_available" class="fw-bold">शौचालय आहे</label>
                    </div>
                </div>

                <div class="col-md-4" id="income_type_div">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="income_type" id="income_type">
                            <option value="">--निवडा--</option>
                            <?php if(mysqli_num_rows($incomeTypes) > 0) {
                                while($incomeType = mysqli_fetch_assoc($incomeTypes)) { ?>
                            <option value="<?php echo $incomeType['income_type']; ?>">
                                <?php echo $incomeType['income_type']; ?>
                            </option>
                            <?php }
                            } ?>
                        </select>
                        <label for="income_type" class="fw-bold">मिळकत प्रकार</label>
                    </div>
                </div>

                <div class="col-md-4 d-none">
                    <div class="form-floating">
                        <select class="form-select border-primary">
                            <option>--निवडा--</option>
                        </select>
                        <label class="fw-bold">करातून सुट/करपात्र असणाऱ्या जमिनी व इमारती</label>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary px-4 me-3" id="generateReportBtn">
                        <i class="fas fa-file-pdf me-2"></i>अहवाल तयार करा
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


    document.addEventListener("DOMContentLoaded", function() {
        const decision_date = document.getElementById('decision_date');

        decision_date.value = new Date().toISOString().split('T')[0];

    });

    $(document).ready(function() {
        // Initially hide all fields except the period field
        $('#malmatta_no_div, #drainage_type_div, #washroom_available_div, #income_type_div').hide();
        console.log(document.getElementById('washroom_available'));

        $('input[type=radio][name=option]').change(function() {


            if (this.value == 'milkat_no') {
                $('#malmatta_no_div').show();
                $('#drainage_type_div').hide();
                $('#washroom_available_div').hide();
                $('#income_type_div').hide();

            } else if (this.value == 'paniwapar') {

                $('#drainage_type_div').show();
                $('#malmatta_no_div').hide();
                $('#washroom_available_div').hide();
                $('#income_type_div').hide();

            } else if (this.value == 'washroom_available') {
                $('#washroom_available_div').show();
                $('#malmatta_no_div').hide();
                $('#drainage_type_div').hide();
                $('#income_type_div').hide();
            } else if (this.value == 'milkat_type') {
                $('#income_type_div').show();
                $('#malmatta_no_div').hide();
                $('#drainage_type_div').hide();
                $('#washroom_available_div').hide();
            } else {
                // Hide all other fields
                $('.form-control.form-select.border-primary, #income_type')
                    .closest('.row')
                    .hide();
            }
        });
    });
    </script>
    <script>
    document.getElementById('pdfForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const period = document.getElementById('period').value;
        const malmatta_no = document.getElementById('malmatta_no').value;
        const drainage_type = document.getElementById('drainage_type').value;
        const washroom_available = document.getElementById('washroom_available').value;
        const income_type = document.getElementById('income_type').value;
        const ahavalType = document.querySelector('input[name="option"]:checked');
        const ahavalTypeValue = ahavalType ? ahavalType.value : '';

        console.log(
            `Selected values: period=${period}, malmatta_no=${malmatta_no}, drainage_type=${drainage_type}, income_type=${income_type}, washroom_available=${washroom_available}, ahavalTypeValue=${ahavalTypeValue}`
        );


        // 👇 Fetch table HTML from your PHP backend
        const res = await fetch(
            `pdf/tax_report_template.php?period=${period}&income_type=${income_type}&malmatta_no=${malmatta_no}&drainage_type=${drainage_type}&washroom_available=${washroom_available}&type=${ahavalTypeValue}`, {
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