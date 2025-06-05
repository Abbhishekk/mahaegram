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
                    <div class="d-sm-flex align-items-center  justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">वार्षिक कर मागणी व वसुली यादी </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 9</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">वार्षिक कर मागणी व वसुली यादी</li>
                        </ol>
                    </div>
                    <?php
                                         if (isset($_SESSION['message'])) {
                                             $message = $_SESSION['message'];
                                             $message_type = $_SESSION['message_type'];
     
                                             echo "<div class='alert alert-$message_type'>$message</div>";
     
                                             // Unset the message so it doesn't persist after refresh
                                             unset($_SESSION['message']);
                                             unset($_SESSION['message_type']);
                                         }
                                         ?>
                    <div class="card p-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="col-md-6 me-4 fw-bold text-primary">
                                    <input type="radio" name="criteria1" id="milkat_criteria" value="milkat" checked
                                        class="me-1 my-2"> मिळकत क्रमांकानुसार
                                </label>
                                <label class="col-md-5 me-4 fw-bold text-primary">
                                    <input type="radio" name="criteria1" id="ekat_criteria" value="ekat"
                                        class="me-1 my-2"> एकत्रीकरण
                                </label>
                                <label class="col-md-3 fw-bold text-primary mt-5">
                                    <input type="radio" name="criteria" id="all_register" value="all_register" checked
                                        class="me-1 my-2"> संपूर्ण रजिस्टर
                                </label>
                                <label class="fw-bold col-md-3 text-primary mt-5">
                                    <input type="radio" name="criteria" id="gava_mangani" value="gava_mangani"
                                        class="me-1 my-2"> गावानुसार मागणी
                                </label>
                                <label class="fw-bold col-md-3 text-primary mt-5">
                                    <input type="radio" name="criteria" id="malmatta_mangani" value="malmatta_mangani"
                                        class="me-1 my-2"> मालमत्तेनुसार मागणी
                                </label>
                            </div>

                            <div class="col-md-6 my-2">
                                <label class="form-label fw-bold">आर्थिक वर्ष :</label>
                                <select class="form-control border-primary" name="financial_year" id="financial_year">
                                    <option value=""> --निवडा-- </option>
                                    <?php foreach ($financialYears as $year): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

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
                            <div class="col-md-2 my-2 ">
                                <button class="ml-3 btn btn-info text-white">शोधा</button>
                            </div>
                            <div class="col-md-6 my-2 ">
                                <label class="form-label" for="kardena_name">कर देणाऱ्याचे नाव</label>
                                <select class="form-select form-control" readonly name="kardena_name" id="kardena_name">
                                    <option>--निवडा--</option>
                                </select>
                            </div>




                            <div class="col-md-12 mb-3 d-flex align-items-end gap-2 my-2">
                                <button class="ml-3 btn btn-primary">ठीक</button>
                                <button class="ml-3 btn btn-secondary">रद्द करणे</button>

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
    <script>
    $(document).ready(function() {
        // Initialize Select2 for the revenue village dropdown
        $('#revenue_village').select2({
            placeholder: 'गाव निवडा',
            allowClear: true
        });

        // Initialize Select2 for the malmatta_id dropdown
        $('#malmatta_id').select2({
            placeholder: 'मालमत्ता क्रमांक निवडा',
            allowClear: true
        });

        // Initialize Select2 for the kardena_name dropdown
        $('#kardena_name').select2({
            placeholder: 'कर देणाऱ्याचे नाव निवडा',
            allowClear: true
        });
    });
    </script>
</body>

</html>