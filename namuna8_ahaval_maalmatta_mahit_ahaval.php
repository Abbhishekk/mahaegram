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
                        <h1 class="h3 mb-0 text-gray-800">मालमत्ता कर आकारणी</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता कर आकारणी</li>
                        </ol>
                    </div>
                    <div class="card rounded p-3">
                        <form action="" id="pdfForm" class="card-body">
                            <div class="row mb-3 my-2">
                                <div class="col-md-12 d-flex flex-wrap gap-4">
                                    <div class="col-md-3 form-check my-2">
                                        <input class="form-check-input" type="radio" name="option" value="milkat_no"
                                            id="milkat_no">
                                        <label class="form-check-label fw-bold text-primary" for="milkat_no">
                                            मिळकत नंबर नुसार अहवाल
                                        </label>
                                    </div>
                                    <div class="col-md-3 form-check my-2">
                                        <input class="form-check-input" type="radio" value="paniwapar" name="option"
                                            id="paniwapar">
                                        <label class="form-check-label fw-bold text-primary" for="paniwapar">
                                            पाणीवापर प्रकार नुसार अहवाल
                                        </label>
                                    </div>
                                    <div class="col-md-3 form-check my-2">
                                        <input class="form-check-input" type="radio" value="washroom_available"
                                            name="option" id="washroom_availables">
                                        <label class="form-check-label fw-bold" for="washroom_availables">
                                            शौचालय आहे
                                        </label>
                                    </div>
                                    <div class="col-md-3 form-check my-2">
                                        <input class="form-check-input" type="radio" name="option" value="milkat_type"
                                            id="milkat_type">
                                        <label class="form-check-label fw-bold text-primary" for="milkat_type">
                                            मिळकत प्रकार
                                        </label>
                                    </div>
                                    <div class="col-md-3 form-check my-2 d-none">
                                        <input class="form-check-input" type="radio" name="option" id="option5">
                                        <label class="form-check-label fw-bold text-primary" for="option5">
                                            फेरफार नुसार अहवाल
                                        </label>
                                    </div>
                                    <div class="col-md-3 form-check my-2 d-none">
                                        <input class="form-check-input" type="radio" name="option" id="option6">
                                        <label class="form-check-label fw-bold text-primary" for="option6">
                                            कमी जास्त पत्रक नुसार अहवाल
                                        </label>
                                    </div>
                                    <div class="col-md-3 form-check my-2 d-none">
                                        <input class="form-check-input" type="radio" name="option" id="option7">
                                        <label class="form-check-label fw-bold text-primary" for="option7">
                                            करातून सूट/करमाफ असणाऱ्या जमिनी व इमारती
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3 my-2" id="period_div">
                                    <label class="form-label fw-bold" for="period">कालावधी</label>
                                    <select class="form-control form-select border-primary" name="period" id="period"> >
                                        <option value="">--निवडा--</option>
                                        <?php if(mysqli_num_rows($periods) > 0) {
                                            while($period = mysqli_fetch_assoc($periods)) {
                                            ?>
                                        <option value="<?php echo $period['id']; ?>">
                                            <?php echo $period['total_period']; ?>
                                        </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2" id="malmatta_no_div">
                                    <label class="form-label fw-bold" for="malmatta_no">मिळकत नंबर</label>
                                    <select class="form-control form-select border-primary" name="malmatta_no"
                                        id="malmatta_no"> >
                                        <option value="">--निवडा--</option>
                                        <?php if(count($malmatta_propertyVerifications) > 0) {
                                            foreach($malmatta_propertyVerifications as $property) {
                                                // print_r($property);
                                            ?>
                                        <option value="<?php echo $property['malmatta_id']; ?>">
                                            <?php echo $property['malmatta_no']; ?>
                                        </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2" id="drainage_type_div">
                                    <label class="form-label fw-bold" for="drainage_type">पाणीवापर प्रकार</label>
                                    <select class="form-control form-select border-primary" name="drainage_type"
                                        id="drainage_type">
                                        <option value="">--निवडा--</option>
                                        <?php 
                                            if(mysqli_num_rows($drainage_type) > 0) {
                                                while($type = mysqli_fetch_assoc($drainage_type)) {
                                                ?>
                                        <option value="<?php echo $type['drainage_type']; ?>">
                                            <?php echo $type['drainage_type']; ?>
                                        </option>
                                        <?php }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2" id="washroom_available_div">
                                    <label class="form-label fw-bold" for="washroom_available">शौचालय आहे</label>
                                    <select class="form-control form-select border-primary" name="washroom_available"
                                        id="washroom_available">
                                        <option value="">--निवडा--</option>
                                        <option value="yes">आहे</option>
                                        <option value="no">नाही</option>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2" id="income_type_div">
                                    <label class="form-label fw-bold" for="income_type">मिळकत प्रकार</label>
                                    <select name="income_type" id="income_type" class="form-control">
                                        <option value="" selected>--निवडा--</option>
                                        <?php
                                                                if(mysqli_num_rows($incomeTypes) > 0){
                                                                    while($incomeType = mysqli_fetch_assoc($incomeTypes)){
                                                                        echo '<option value="'.$incomeType['income_type'].'">'.$incomeType['income_type'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                    </select>
                                </div>
                                <div class="col-md-3 my-2 d-none">
                                    <label class="form-label fw-bold">करातून सुट/करपात्र असणाऱ्या जमिनी व इमारती</label>
                                    <select class="form-control form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" id="generateReportBtn">अहवाल तयार
                                    करा</button>
                            </div>
                        </form>
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