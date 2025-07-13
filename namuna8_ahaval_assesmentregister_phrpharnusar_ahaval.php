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
                        <h1 class="h3 mb-0 text-gray-800">नमुना क्रमांक ८ कर नोंद वही अहवाल (असेसमेन्ट रजिस्टर)</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">अहवाल</li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना क्रमांक ८ कर नोंद वही अहवाल
                                (असेसमेन्ट रजिस्टर)</li>
                        </ol>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">अहवाल</h6>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="option" id="option1" checked>
                                        <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="option1">
                                            <i class="fas fa-exchange-alt me-2"></i>फेरफार नुसार अहवाल
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="option" id="option2">
                                        <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="option2">
                                            <i class="fas fa-balance-scale me-2"></i>कमी जादा पत्रक नुसार अहवाल
                                        </label>
                                    </div>
                                </div>
                    
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select border-primary">
                                                <option>--निवडा--</option>
                                            </select>
                                            <label class="fw-bold">कालावधी</label>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-4">
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
                                        <button type="submit" class="btn btn-primary px-4 me-3">
                                            <i class="fas fa-file-pdf me-2"></i>अहवाल तयार करा
                                        </button>
                                        <button type="reset" class="btn btn-outline-danger px-4">
                                            <i class="fas fa-times me-2"></i>रद्द करा
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
</body>

</html>