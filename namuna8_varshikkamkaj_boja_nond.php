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
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna8';
        $subpage = 'varshik_kamkaj';
      
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
                  include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid bg-white p-4 border rounded">
                    <!-- Header and Breadcrumb -->
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div><strong>बोजा नोंद /कमी करणे</strong></div>
                        <div><a href="#"><i class="fa fa-home"></i> Home</a> / नमुना क्रमांक 8 / <strong>बोजा नोंद /कमी
                                करणे</strong></div>
                    </div>

                    <!-- Form Section -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">मालमत्ता बोजा नोंद</h6>
                        </div>
                        <div class="card-body">
                            <!-- मालमत्ता माहिती -->
                            <div class="mb-4 p-3 border rounded bg-light">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-circle me-2" style="font-size: 8px;"></i>
                                    <h6 class="m-0 fw-bold">मालमत्ता माहिती</h6>
                                </div>
                                
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary" id="malmattaNumber" placeholder=" ">
                                            <label for="malmattaNumber" class="fw-bold">मालमत्ता क्रमांक <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary h-100">
                                            <i class="fas fa-search me-1"></i> शोधा
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary" id="ownerName" placeholder=" ">
                                            <label for="ownerName" class="fw-bold">मालमत्ता धारकांचे नाव</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" id="period">
                                                <option selected>2023 - 2027</option>
                                                <option>2024 - 2028</option>
                                                <option>2025 - 2029</option>
                                            </select>
                                            <label for="period" class="fw-bold">कालावधी</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <!-- नवीन बोजा नोंद करणे -->
                            <div class="mb-4 p-3 border rounded bg-light">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-circle me-2" style="font-size: 8px;"></i>
                                    <h6 class="m-0 fw-bold">नवीन बोजा नोंद करणे <span class="text-danger">*</span></h6>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary" id="newBoja" placeholder=" ">
                                    <label for="newBoja">नवीन बोजा नोंद</label>
                                </div>
                            </div>
                    
                            <!-- जुन्या बोजाची माहिती -->
                            <div class="mb-4 p-3 border rounded bg-light">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="bojatype" id="oldboja">
                                    <label class="form-check-label fw-bold" for="oldboja">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> जुना बोजा
                                    </label>
                                </div>
                            </div>
                    
                            <!-- Buttons -->
                            <div class="d-flex gap-3 mt-4">
                                <button class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i> साठवा
                                </button>
                                <button class="btn btn-outline-danger px-4">
                                    <i class="fas fa-times me-2"></i> रद्द करा
                                </button>
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