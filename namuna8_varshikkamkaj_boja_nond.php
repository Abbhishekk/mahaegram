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
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
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
                    <div class="p-3 bg-light border rounded">
                        <!-- मालमत्ता माहिती -->
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fa fa-circle" style="font-size: 8px;"></i>
                                मालमत्ता माहिती</label>
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">मालमत्ता क्रमांक <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="मालमत्ता क्रमांक">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary mt-2">शोधा</button>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">मालमत्ता धारकांचे नाव :</label>
                                    <input type="text" class="form-control" placeholder="मालमत्ता धारकांचे नाव">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">कालावधी</label>
                                    <select class="form-control">
                                        <option selected>2023 - 2027</option>
                                        <option>2024 - 2028</option>
                                        <option>2025 - 2029</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- नवीन बोजा नोंद करणे -->
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fa fa-circle" style="font-size: 8px;"></i> नवीन
                                बोजा नोंद करणे <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="नवीन बोजा नोंद">
                        </div>

                        <!-- जुन्या बोजाची माहिती -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="bojatype" id="oldboja">
                            <label class="form-check-label" for="oldboja">जुना बोजा</label>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">साठवा</button>
                            <button class="btn btn-secondary">रद्द करा</button>
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