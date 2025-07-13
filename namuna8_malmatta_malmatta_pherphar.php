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
        $subpage = 'malmatta';
        
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
                include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <!-- Container Fluid -->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">मालमत्ता फेरफार अर्ज (मिळकत हस्तांतरण / नाव कमी करणे / नाव
                            लावणे)</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मालमत्ता फेरफार अर्ज</li>
                        </ol>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">मिळकत फेरफार अर्ज</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="process.php">
                                <!-- मिळकत माहिती Section -->
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    <h5 class="m-0 text-primary">मिळकत माहिती</h5>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" required>
                                                <option>वॉर्ड निवडा</option>
                                            </select>
                                            <label>वॉर्ड क्र <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary" placeholder="मालमत्ता क्रमांक निवडा">
                                            <label>मालमत्ता क्रमांक <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary">
                                            <label>मिळकत प्रकार <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary">
                                            <label>मिळकत धारकांची नावे <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary">
                                            <label>लांबी</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary">
                                            <label>रुंदी</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary">
                                            <label>क्षेत्रफळ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary">
                                            <label>भोगवट धारकांची नावे</label>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- फेरफार प्रकार आणि अर्जदार माहिती Section -->
                                <div class="d-flex align-items-center mt-4 mb-3">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <h5 class="m-0 text-primary">फेरफार प्रकार आणि अर्जदार माहिती</h5>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select border-primary" required>
                                                <option>अर्जदाराचे नाव निवडा</option>
                                            </select>
                                            <label>अर्जदाराचे नांव <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary btn-block">
                                            <i class="fas fa-plus me-2"></i>नवीन नाव नोंद
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-primary">
                                            <label>मोबाईल क्रमांक <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control border-primary" value="2025-04-21">
                                            <label>अर्जाचा दिनांक <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chk1">
                                                <label class="form-check-label" for="chk1">मिळकतधारक नावात फेरफार</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chk2">
                                                <label class="form-check-label" for="chk2">मिळकतधारक नाव कमी करणे</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chk3">
                                                <label class="form-check-label" for="chk3">नाव कमी करणे</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chk4">
                                                <label class="form-check-label" for="chk4">भोगवटधारक नाव कमी करणे</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>साठवा
                                    </button>
                                    <button type="reset" class="btn btn-outline-danger px-4">
                                        <i class="fas fa-times me-2"></i>रद्द करणे
                                    </button>
                                </div>
                            </form>
                    
                            <!-- Table Section -->
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>अ.क्र.</th>
                                            <th>अर्जदाराचे नांव</th>
                                            <th>अर्ज दिनांक</th>
                                            <th>मिळकत क्रमांक</th>
                                            <th>फेरफार प्रकार</th>
                                            <th>अर्जाची स्थिती</th>
                                            <th>शेरा</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="text-center">No records to display.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Container Fluid -->

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