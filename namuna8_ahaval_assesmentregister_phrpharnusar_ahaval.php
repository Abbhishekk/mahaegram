<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "नमुना क्रमांक ८ कर नोंद वही अहवाल (असेसमेन्ट रजिस्टर)";
?>
<?php include('include/header.php'); ?>
<?php
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
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
                        <h1 class="h3 mb-0 text-gray-800">नमुना क्रमांक ८ कर नोंद वही अहवाल (असेसमेन्ट रजिस्टर)</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना क्रमांक ८ कर नोंद वही अहवाल
                                (असेसमेन्ट रजिस्टर)</li>
                        </ol>
                    </div>
                    <div class="border card rounded p-3">
                        <form action="" class="card-body">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="option" id="option1" checked>
                                <label class="form-check-label fw-bold text-primary" for="option1">
                                    फेरफार नुसार अहवाल
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="option" id="option1" checked>
                                <label class="form-check-label fw-bold text-primary" for="option1">
                                    कमी जादा पत्रक नुसार अहवाल
                                </label>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">कालावधी</label>
                                    <select class="form-control form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">आर्थिक वर्ष</label>
                                    <select class="form-control form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                </div>
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
</body>

</html>