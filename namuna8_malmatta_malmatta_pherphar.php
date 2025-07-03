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
                <div class="container-fluid">
                    <!-- Heading & Breadcrumb -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h5 class="text-primary font-weight-bold">मालमत्ता फेरफार (मिक्कत हस्तांतरण / नाव कमी करणे)</h5>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item">नमुना क्रमांक 8</li>
                                <li class="breadcrumb-item active" aria-current="page">मालमत्ता फेरफार</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link active">आलेले अर्ज.</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">फेरफार केलेले अर्ज.</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">फेरफार रिजेक्ट अर्ज.</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">फेरफार प्रलंबित.</a>
                        </li>
                    </ul>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>अ.क्र.</th>
                                    <th>अर्ज.क्र</th>
                                    <th>अर्जदाराचे नाव</th>
                                    <th>वॉर्ड क्रमांक</th>
                                    <th>मिक्कत क्रमांक</th>
                                    <th>मिक्कत प्रकार</th>
                                    <th>मिक्कतधारकाचे नाव</th>
                                    <th>फेरफार प्रकार</th>
                                    <th>फेरफार</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center">No records to display.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Accordion Sections -->
                    <div class="accordion mt-4" id="ferfarAccordion">
                        <!-- Section 1 -->
                        <div class="card">
                            <div class="card-header bg-primary text-white" id="headingOne">
                                <h6 class="mb-0">
                                    <button class="btn btn-link text-white" type="button" data-toggle="collapse"
                                        data-target="#collapseOne">
                                        मिक्कतधारक नाव फेरफार
                                    </button>
                                </h6>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#ferfarAccordion">
                                <div class="card-body">
                                    <!-- Content -->
                                </div>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div class="card">
                            <div class="card-header bg-primary text-white" id="headingTwo">
                                <h6 class="mb-0">
                                    <button class="btn btn-link text-white" type="button" data-toggle="collapse"
                                        data-target="#collapseTwo">
                                        मिक्कतधारक नाव कमी करणे
                                    </button>
                                </h6>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#ferfarAccordion">
                                <div class="card-body">
                                    <!-- Content -->
                                </div>
                            </div>
                        </div>

                        <!-- Section 3 -->
                        <div class="card">
                            <div class="card-header bg-primary text-white" id="headingThree">
                                <h6 class="mb-0">
                                    <button class="btn btn-link text-white" type="button" data-toggle="collapse"
                                        data-target="#collapseThree">
                                        भोगवटधारक नाव कमी करणे
                                    </button>
                                </h6>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#ferfarAccordion">
                                <div class="card-body">
                                    <!-- Content -->
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: सभा माहिती -->
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">मासिक सभा ठराव माहिती</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>मासिक सभा दिनांक <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" value="2025-04-21">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>ठराव क्रमांक <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>शेरा</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary">साठवा</button>
                                    <button type="reset" class="btn btn-info">रिसेट करा</button>
                                    <button type="button" class="btn btn-secondary">रद्द करा</button>
                                </div>
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
</body>

</html>