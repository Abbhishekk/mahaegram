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
$lgdVillages = $fun->getVillagesWithPanchayat($_SESSION['panchayat_code']);
    $property_verifications = $fun->getPropertyVerificationsAccordingToPanchayat();
    $wards = $fun->getWard($_SESSION['district_code']);
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
                <div class="container-fluid border rounded p-3">
                    <div class="bg-light p-2 mb-3 border-bottom">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">कर मागणी बिल</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                                <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                                <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                                <li class="breadcrumb-item active" aria-current="page">कर मागणी बिल</li>
                            </ol>
                        </div>
                        <p class="text-primary small m-0">
                            टीप:- नमुना १/पाणपट्टी रजिस्टर/किरकोळ मागणी पूर्ण तयार केले नंतरच मागणी बिल तयार करावे.
                            कर मागणी बिल तयार करताना कर मागणी बिलाची तारीख खाली करून निवडावी कारण कर मागणी बिल तयार
                            केल्यानंतर तारीख बदलता येत नाही
                        </p>
                    </div>

                    <form action="">
                        <div class="card p-4">
                            <?php
                                if (isset($_SESSION['message'])) {
                                    echo "<div class='alert alert-{$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_area" class="me-1" checked> ग्रामनिधी</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_area" class="me-1"> ग्राम पाणीपुरवठा निधी</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_area" class="me-1"> किरकोळ मागणी</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_type" class="me-1" checked> संपूर्ण बिल</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_type" class="me-1"> वैयक्तिक बिल</label>
                                    <label class="me-3 col-md-3 fw-bold text-secondary"><input type="radio"
                                            name="bill_type" class="me-1"> वाई नुसार</label>
                                    <label class="fw-bold col-md-2 text-secondary"><input type="radio" name="bill_type"
                                            class="me-1">
                                        रस्ता नुसार</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-group col-md-4">
                                    <label for="revenue_village">गावाचे नाव<span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2-single-placeholder mb-3" name="revenue_village"
                                        id="revenue_village">
                                        <option value="" selected>--निवडा.--</option>
                                        <?php
                                                            if(mysqli_num_rows($lgdVillages) > 0){
                                                                while($village = mysqli_fetch_assoc($lgdVillages)){
                                                                    echo "<option value='".$village['Village_Code']."'>".$village['Village_Name']."</option>";
                                                                }
                                                            }
                                                        ?>
                                    </select>

                                </div>
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
                                    <label class="form-label fw-bold">दिनांक <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" value="2025-05-22">
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
                                <div class="col-md-4 my-2 ">
                                    <label class="form-label" for="malmatta_id">मालमत्ता क्रमांक</label>
                                    <select class="form-select form-control" name="malmatta_id" id="malmatta_id">
                                        <option>--निवडा--</option>
                                        <?php
                                            foreach($property_verifications as $property){
                                                if($property['status'] != 0) continue; // Skip if malmatta_id is 0
                                                echo "<option value='{$property['malmatta_id']}'>{$property['malmatta_no']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button class="btn btn-primary w-100">शोधा</button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">कर देणाऱ्याचे नाव <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control">
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