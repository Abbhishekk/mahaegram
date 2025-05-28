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
               
                <div class="container border rounded p-3">
    <h5 class="fw-bold text-secondary mb-3 text-center">कर थकबाकी यादी</h5>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="me-4 fw-bold text-secondary d-inline-block me-3">
                <input type="radio" name="bill_type" checked class="me-1"> कर थकबाकी बिल (घरफाळा)
            </label>
            <label class="me-4 fw-bold text-secondary d-inline-block me-3">
                <input type="radio" name="bill_type" class="me-1"> कर थकबाकी बिल (पाणीपट्टी)
            </label>
            <label class="fw-bold text-secondary d-inline-block">
                <input type="radio" name="bill_type" class="me-1"> कर थकबाकी बिल (किरकोळ)
            </label>
        </div>

        <div class="col-md-12 mb-3">
            <label class="me-3 fw-bold text-secondary d-inline-block me-3">
                <input type="radio" name="criteria" checked class="me-1"> वॉर्ड नुसार
            </label>
            <label class="me-3 fw-bold text-secondary d-inline-block me-3">
                <input type="radio" name="criteria" class="me-1"> गावानुसार
            </label>
            <label class="me-3 fw-bold text-secondary d-inline-block me-3">
                <input type="radio" name="criteria" class="me-1"> रस्त्यानुसार
            </label>
            <label class="fw-bold text-secondary d-inline-block">
                <input type="radio" name="criteria" class="me-1"> मिळकत क्रमांक अनुसार
            </label>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">आर्थिक वर्ष <span class="text-danger">*</span></label>
            <select class="form-select">
                <option>Select</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">वॉर्डचे नाव <span class="text-danger">*</span></label>
            <select class="form-select">
                <option>निवडा</option>
            </select>
        </div>

        <div class="col-md-12 mb-3 d-flex justify-content-center">
            <button class="btn btn-danger">रद्द करणे</button>
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