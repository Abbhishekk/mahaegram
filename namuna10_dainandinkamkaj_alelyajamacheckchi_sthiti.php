<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "आलेल्या (जमा) चेकची स्थिती";
?>
<?php include('include/header.php'); ?>
<?php
    $newName = $fun->getNewName();
    $periods = $fun->getPeriodDetails($_SESSION['district_code']);
    $financialYears = $fun->getYearArray($periods);

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
    <h5 class="fw-bold text-secondary mb-3">आलेल्या (जमा) चेकची स्थिती</h5>

    <div class="row mb-3">
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">आर्थिक वर्ष :</label>
            <select class="form-control border-primary" name="financial_year" id="financial_year" >
                <option value=""> --निवडा-- </option>
                <?php foreach ($financialYears as $year): ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold" for="plan_name" >फंडाचे नाव <span class="text-danger">*</span></label>
             <select class="form-control" name="plan_name" id="plan_name" required>
                                                    <option value="">--निवडा--</option>
                                                    <option value="ग्रामनिधी">ग्रामनिधी</option>
                                                    <option value="ग्राम पाणीपुरवठा निधी">ग्राम पाणीपुरवठा निधी</option>
                                                </select>
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">दिनांक :</label>
            <input type="date" class="form-control border-primary" name="date" id="date">
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">चेक क्रमांक <span class="text-danger">*</span></label>
            <select class="form-control form-select border-primary" name="check_number" id="check_number" >
                <option>निवडा</option>
            </select>
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">चेक मिळालेली दिनांक :</label>
            <input type="date" class="form-control border-primary" name="check_received_date" id="check_received_date">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">बँक नाव</label>
            <input type="text" class="form-control border-primary" name="bank_name" id="bank_name" placeholder="बँक नाव">
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">चेकची रक्कम</label>
            <input type="text" class="form-control border-primary" name="check_amount" id="check_amount" placeholder="चेकची रक्कम">
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">चेक जमा केलेल्या बँकेचे नाव <span class="text-danger">*</span></label>
            <select class="form-control form-select border-primary" name="bank_deposited" id="bank_deposited">
                <option>--निवडा--</option>
            </select>
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">चेक स्थिती <span class="text-danger">*</span></label>
            <select class="form-control form-select border-primary" name="check_status" id="check_status" >
                <option>निवडा</option>
            </select>
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">मिळलेली दिनांक :</label>
            <input type="date" class="form-control border-primary" name="received_date" id="received_date">
        </div>
        <div class="col-md-3 my-2">
            <label class="form-label fw-bold">पुस्तक क्रमांक <span class="text-danger">*</span></label>
            <input type="text" class="form-control border-primary" name="book_number" id="book_number" placeholder="पुस्तक क्रमांक">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-2">
            <label class="form-label fw-bold">पावती क्रमांक <span class="text-danger">*</span></label>
            <select class="form-control form-select border-primary" name="receipt_number" id="receipt_number">
                <option>--निवडा--</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold">पावती रद्द कारण <span class="text-danger">*</span></label>
            <input type="text" class="form-control border-primary" name="reason" id="reason"  placeholder="पावती रद्द कारण">
        </div>
    </div>

    <div class="row mb-3">
        <div class="d-grid gap-2 col-6 mx-auto">
            <button class="btn btn-primary" type="button">साठवा</button>
            <button class="btn btn-secondary" type="button">रद्द करणे</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th>अ क्रं</th>
                    <th>आर्थिक वर्ष</th>
                    <th>चेक मिळालेचा दिनांक</th>
                    <th>खात्यात</th>
                    <th>बँक नाव</th>
                    <th>चेक क्रमांक</th>
                    <th>चेक स्थिती</th>
                    <th>चेकची रक्कम</th>
                    <th>चेक जमा केलेल्या बँकेचे नाव</th>
                    <th>बदल</th>
                    <th>पावती</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="11" class="text-center">No records to display.</td>
                </tr>
            </tbody>
        </table>
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