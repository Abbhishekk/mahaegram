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
     $periods = $fun->getPeriodTotalPeriodsWithPeriodReason("नमुना नंबर 8 कालावधी",$_SESSION['district_code']);
    if (empty($periods)) {
        $_SESSION['message'] = "कालावधी उपलब्ध नाही.";
        $_SESSION['message_type'] = "danger";
      
    }
    $financialYears = $fun->getYearArray($periods);
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna9';
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
                <div class="container-fluid border rounded p-3">
                    <div class="bg-light p-2 mb-3 border-bottom">
                        <h5 class="fw-bold text-secondary">जप्तीच्या अधिपत्राचा नमुना तयार करणे</h5>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">जप्तीच्या अधिपत्राचा नमुना तयार करणे</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                                <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                                <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                                <li class="breadcrumb-item active" aria-current="page">जप्तीच्या अधिपत्राचा नमुना तयार
                                    करणे</li>
                            </ol>
                        </div>
                        <p class="text-danger small m-0 fw-bold">
                            टीप : नमुना १ / मागणी लेखा (नोटीस) तयार झाले नंतरच जप्तीच्या अधिपत्राचा नमुना तयार करणे
                        </p>
                    </div>
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">जप्तीच्या अधिपत्राचा नमुना</h6>
    </div>
    
        <form action="">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>
        <div class="card-body">
             <?php
                            if (isset($_SESSION['message'])) {
                                echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                unset($_SESSION['message']);
                                unset($_SESSION['message_type']);
                            }
                            ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select border-primary" name="financial_year" id="financial_year">
                            <option value="">--निवडा--</option>
                            <?php foreach ($financialYears as $year): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="financial_year" class="fw-bold">आर्थिक वर्ष</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" class="form-control border-primary" value="2025-05-22">
                        <label class="fw-bold">तारीख</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control border-primary">
                        <label class="fw-bold">ठराव न. क्रमांक <span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <div class="row mb-4 mt-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">कर</label>
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kar" id="imarat_kar" checked>
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="imarat_kar">
                                <i class="fas fa-building me-2"></i>इमारत कर
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kar" id="panipatti">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="panipatti">
                                <i class="fas fa-tint me-2"></i>पाणीपट्टी
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kar" id="kirokul_magni">
                            <label class="form-check-label fw-bold btn btn-outline-primary py-2 px-4 rounded-pill" for="kirokul_magni">
                                <i class="fas fa-store me-2"></i>किरकोळ मागणी
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary px-4 me-3">
                        <i class="fas fa-file-contract me-2"></i>जप्तीच्या अधिपत्राचा नमुना तयार करणे
                    </button>
                    <button type="reset" class="btn btn-outline-danger px-4">
                        <i class="fas fa-times me-2"></i>रद्द करणे
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