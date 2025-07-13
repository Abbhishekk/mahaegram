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
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक ८</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता कर आकारणी</li>
                        </ol>
                    </div>
                   <div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">मालमत्ता कर आकारणी अहवाल</h6>
    </div>
    <div class="card-body">
        <form action="" id="pdfForm">
            <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="option" id="milkat_no" value="milkat_no" checked>
                    <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="milkat_no">
                        <i class="fas fa-hashtag me-2"></i>मिळकत नंबर नुसार अहवाल
                    </label>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4" id="period_div">
                    <div class="form-floating">
                        <select class="form-select select2-single-placeholder border-primary" name="period" id="period">
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
                    <div class="form-floating border-primary  ">
                        <select class="form-select select2 select2-single-placeholder border-primary " name="malmatta_no" id="malmatta_no">
                            <option value="">--निवडा--</option>
                            <?php if(count($malmatta_propertyVerifications) > 0) {
                                foreach($malmatta_propertyVerifications as $property) {
                                                                                $format = ($property['ward_name']!= "" ? $property['ward_name'] :"वॉर्ड नाव")." / ".($property['property_road_name'] != "" ? $property['property_road_name'] : "रस्त्याचे नाव")." / रजिस्टर नं- ".($property['register_no']!="" ? $property['register_no']:"0")." / खासरा नं- ".($property['khasara_no']!="" ? $property['khasara_no']:"0")." / मालमत्ता नं- ".$property['malmatta_no'];

                                ?>
                            <option value="<?php echo $property['malmatta_id']; ?>">
                                <?php echo $format; ?>
                            </option>
                            <?php }
                            } ?>
                        </select>
                        <label for="malmatta_no" class="fw-bold">मिळकत नंबर</label>
                    </div>
                </div>

                <div class="col-md-4 d-none">
                    <div class="form-floating">
                        <select class="form-select border-primary">
                            <option>--निवडा--</option>
                        </select>
                        <label class="fw-bold">आर्थिक वर्ष</label>
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
    
    <!--this script for select 2-->
    <script>
$(document).ready(function () {
  $('#malmatta_no').select2({
    placeholder: "--निवडा--",
    allowClear: true,
    width: 'resolve'  // Auto-resolves to the container's width
  });
});
</script>
</body>

</html>