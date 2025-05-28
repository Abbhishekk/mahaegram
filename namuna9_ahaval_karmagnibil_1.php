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
    <div class="bg-light p-2 mb-3 border-bottom">
        <h5 class="fw-bold text-secondary">कर मागणी बिल</h5>
        <p class="text-primary small m-0">
            टीप:- नमुना १/पाणपट्टी रजिस्टर/किरकोळ मागणी पूर्ण तयार केले नंतरच मागणी बिल तयार करावे.
            कर मागणी बिल तयार करताना कर मागणी बिलाची तारीख खाली करून निवडावी कारण कर मागणी बिल तयार केल्यानंतर तारीख बदलता येत नाही
        </p>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label class="me-3 fw-bold text-secondary"><input type="radio" name="bill_area" class="me-1" checked> ग्रामनिधी</label>
            <label class="me-3 fw-bold text-secondary"><input type="radio" name="bill_area" class="me-1"> ग्राम पाणीपुरवठा निधी</label>
            <label class="me-3 fw-bold text-secondary"><input type="radio" name="bill_area" class="me-1"> किरकोळ मागणी</label>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <label class="me-3 fw-bold text-secondary"><input type="radio" name="bill_type" class="me-1" checked> संपूर्ण बिल</label>
            <label class="me-3 fw-bold text-secondary"><input type="radio" name="bill_type" class="me-1"> वैयक्तिक बिल</label>
            <label class="me-3 fw-bold text-secondary"><input type="radio" name="bill_type" class="me-1"> वाई नुसार</label>
            <label class="fw-bold text-secondary"><input type="radio" name="bill_type" class="me-1"> रस्ता नुसार</label>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label fw-bold">गावाचे नाव <span class="text-danger">*</span></label>
            <select class="form-select">
                <option>--निवडा--</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">आर्थिक वर्ष <span class="text-danger">*</span></label>
            <select class="form-select">
                <option>--निवडा--</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">दिनांक <span class="text-danger">*</span></label>
            <input type="date" class="form-control" value="2025-05-22">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label fw-bold">वॉर्डचे नाव <span class="text-danger">*</span></label>
            <select class="form-select">
                <option>निवडा</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">मिळकत क्रमांक <span class="text-danger">*</span></label>
            <input type="text" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary w-100">शोधा</button>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label fw-bold">कर देणाऱ्याचे नाव <span class="text-danger">*</span></label>
            <select class="form-select">
                <option></option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">सरपंच सही</label>
            <input type="file" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">ग्रामसेवक सही</label>
            <input type="file" class="form-control">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12 d-flex gap-2 justify-content-start">
            <button class="ml-3 btn btn-primary">अपलोड</button>
            <button class=" ml-3 btn btn-primary">कर मागणी बिल तयार करणे</button>
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