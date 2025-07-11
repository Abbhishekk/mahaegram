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
                    <div class="border card  rounded p-3">
                        <form action="" id="pdfForm" class="card-body">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="option" id="milkat_no"
                                    value="milkat_no" checked>
                                <label class="form-check-label fw-bold text-primary" for="milkat_no">
                                    मिळकत नंबर नुसार अहवाल
                                </label>
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
                                    <select class="form-control form-select border-primary select2-single-placeholder" name="malmatta_no"
                                        id="malmatta_no">
                                        <option value="">--निवडा--</option>
                                        <?php if(count($malmatta_propertyVerifications) > 0) {
                                            foreach($malmatta_propertyVerifications as $property) {
                                                // print_r($property);
                                                $format = ($property['ward_name']!= "" ? $property['ward_name'] :"वॉर्ड नाव")." / ".($property['property_road_name'] != "" ? $property['property_road_name'] : "रस्त्याचे नाव")." / रजिस्टर नं- ".($property['register_no']!="" ? $property['register_no']:"0")." / खासरा नं- ".($property['khasara_no']!="" ? $property['khasara_no']:"0")." / मालमत्ता नं- ".$property['malmatta_no'];
                                            ?>
                                        <option value="<?php echo $property['malmatta_id']; ?>">
                                            <?php echo $format; ?>
                                        </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-none ">
                                    <label class="form-label fw-bold">आर्थिक वर्ष</label>
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
    </script>
    <script>
    document.getElementById('pdfForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const period = document.getElementById('period').value;
        const malmatta_no = document.getElementById('malmatta_no').value;

        const ahavalType = document.querySelector('input[name="option"]:checked');
        const ahavalTypeValue = ahavalType ? ahavalType.value : '';

        console.log(
            `Selected values: period=${period}, malmatta_no=${malmatta_no}, ahavalTypeValue=${ahavalTypeValue}`
        );


        // 👇 Fetch table HTML from your PHP backend
        const res = await fetch(
            `pdf/tax_report_template.php?period=${period}&malmatta_no=${malmatta_no}&type=${ahavalTypeValue}`, {
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