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
    <h5 class="fw-bold text-secondary mb-3">वार्षिक कर मागणी व वसुली यादी</h5>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="col-md-6 me-4 fw-bold text-primary">
                <input type="radio" name="criteria" checked class="me-1"> मिळकत क्रमांकानुसार
            </label>
            <label class="col-md-6 me-4 fw-bold text-primary">
                <input type="radio" name="criteria" class="me-1"> एकत्रीकरण
            </label>
            
        </div>

        <div class="col-md-6 mb-3">
            <label class="me-4 fw-bold text-primary">
                <input type="radio" name="reg_type" checked class="me-1"> संपूर्ण रजिस्टर
            </label>
            <label class="ml-5 form-label">आर्थिक वर्ष <span class="text-danger">*</span></label>
            <select class="form-select border-primary">
                <option>--निवडा--</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
        <label class="fw-bold text-primary">
                <input type="radio" name="criteria" class="me-1"> गावानुसार मागणी
            </label>
            <label class="ml-5 form-label">गावाचे नाव <span class="text-danger">*</span></label>
            <select class="form-select border-primary">
                <option>--निवडा--</option>
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label class="fw-bold text-primary">
                <input type="radio" name="reg_type" class="me-1"> मालमत्तेनुसार मागणी
            </label>
            <label class="ml-5 form-label">वाड्याचे नाव <span class="text-danger">*</span></label>
            <select class="form-select border-primary">
                <option>--निवडा--</option>
            </select>
            <label class="ml-3 form-label">मालमत्ता क्रमांक <span class="text-danger">*</span></label>
            <select class="form-select border-primary">
                <option>--निवडा--</option>
            </select>
            <button class="ml-3 btn btn-info text-white">शोधा</button>
            <label class=" ml-3 form-label">कर देणाऱ्याचे नाव <span class="text-danger">*</span></label>
            <select class="form-select border-primary">
                <option>--निवडा--</option>
            </select>
        </div>

        

        <div class="col-md-12 mb-3 d-flex align-items-end gap-2">
            <button class="ml-3 btn btn-primary">ठीक</button>
            <button class="ml-3 btn btn-secondary">रद्द करणे</button>
            
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