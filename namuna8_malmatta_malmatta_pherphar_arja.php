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

                    <div class="card p-4">
                        <form method="post" action="process.php">
                            <!-- मिळकत माहिती Section -->
                            <h5 class="text-primary mb-3"><i class="fas fa-info-circle"></i> मिळकत माहिती</h5>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>वॉर्ड क्र <span class="text-danger">*</span></label>
                                    <select class="form-control" required>
                                        <option>वॉर्ड निवडा</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>मालमत्ता क्रमांक <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="मालमत्ता क्रमांक निवडा">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>मिळकत प्रकार <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>मिळकत धारकांची नावे <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>लांबी</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>रुंदी</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>क्षेत्रफळ</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>भोगवट धारकांची नावे</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <!-- फेरफार प्रकार आणि अर्जदार माहिती Section -->
                            <h5 class="text-primary mt-4 mb-3"><i class="fas fa-user"></i> फेरफार प्रकार आणि अर्जदार
                                माहिती</h5>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>अर्जदाराचे नांव <span class="text-danger">*</span></label>
                                    <select class="form-control" required>
                                        <option>अर्जदाराचे नाव निवडा</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-info btn-block">नवीन नाव नोंद</button>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>मोबाईल क्रमांक <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>अर्जाचा दिनांक <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" value="2025-04-21">
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="form-group col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="chk1">
                                        <label class="form-check-label" for="chk1">मिळकतधारक नावात फेरफार</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="chk2">
                                        <label class="form-check-label" for="chk2">मिळकतधारक नाव कमी करणे</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="chk3">
                                        <label class="form-check-label" for="chk3">नाव कमी करणे</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="chk4">
                                        <label class="form-check-label" for="chk4">भोगवटधारक नाव कमी करणे</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">साठवा</button>
                            <button type="reset" class="btn btn-secondary">रद्द करणे</button>
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