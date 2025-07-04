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
    $wards = $fun->getWard($_SESSION['district_code']);
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
        include('include/sidebar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid border rounded p-3">
                    <div class="bg-light p-2 mb-3 border-bottom">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">मागणी लेखा (नोटीस) तयार करणे</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                                <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                                <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                                <li class="breadcrumb-item active" aria-current="page">मागणी लेखा (नोटीस) तयार करणे</li>
                            </ol>
                        </div>
                        <p class="text-danger small m-0 fw-bold">
                            टीप : नमुना १ / कर मागणी बिल पूर्ण तयार झाले नंतरच मागणी हुकूम तयार करावे
                        </p>
                    </div>
                    <form action="">
                        <?php
                                if (isset($_SESSION['message'])) {
                                    echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                        <div class="card p-4">
                            <div class="row mb-3">
                                <div class="col-md-6 my-2">
                                    <label class="form-label fw-bold">आर्थिक वर्ष :</label>
                                    <select class="form-control border-primary" name="financial_year"
                                        id="financial_year">
                                        <option value=""> --निवडा-- </option>
                                        <?php foreach ($financialYears as $year): ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">हुकूम दिनांक <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" value="2025-05-22">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">ठराव न. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">एकरकमी नोटीस रक्कम <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3 my-2">
                                <div class="col-md-12 d-flex flex-wrap gap-4">
                                    <label class="ml-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="notice_type" class="me-1" checked> ग्रामनिधी नोटीस</label>
                                    <label class="ml-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="notice_type" class="me-1"> ग्राम पाणीपुरवठा निधी</label>
                                    <label class="ml-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="notice_type" class="me-1"> किरकोळ मागणी</label>
                                    <label class="ml-3 col-md-2 fw-bold text-secondary"><input type="radio"
                                            name="notice_type" class="me-1"> वॉर्डनुसार यादी तयार करणे</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 my-2 ">
                                    <label class="form-label" for="ward">वॉर्ड नाव</label>
                                    <select class="form-select form-control" name="ward" id="ward">
                                        <option>निवडा</option>
                                        <?php
                                            while($ward = mysqli_fetch_assoc($wards)){
                                                echo "<option value='{$ward['ward_name']}'>{$ward['ward_name']}</option>";
                                            }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 d-flex gap-2">
                                    <button class="ml-3 btn btn-primary">मागणी लेखा (नोटीस) तयार करणे</button>
                                    <button class="ml-3 btn btn-secondary">रद्द करणे</button>
                                </div>
                            </div>

                        </div>

                    </form>

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