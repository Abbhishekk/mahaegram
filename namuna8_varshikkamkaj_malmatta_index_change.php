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
        $subpage = 'varshik_kamkaj';
       
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <!-- TopBar -->
        <?php include('include/topbar.php');
             include('include/sidebar.php'); ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="card shadow mb-4">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="fw-bold">नमुना क्रमांक 8 / मालमत्ता अ.क्र. बदला</div>
                <div class="text-muted small"><a href="#" class="text-decoration-none">Home</a> / नमुना क्रमांक 8 / मालमत्ता अ.क्र. बदला</div>
            </div>
            <div class="card-body">
                <!-- Breadcrumb -->
                
        
                <!-- Filter Section Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">अहवाल</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-select border-primary">
                                        <option>2023 - 2027</option>
                                    </select>
                                    <label class="fw-bold">कालावधी</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-select border-primary">
                                        <option>तलवाडा</option>
                                    </select>
                                    <label class="fw-bold">गावाचे नाव</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                    <label class="fw-bold">रस्त्याचे नाव / गल्लीस क्रमांक <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                    <label class="fw-bold">वॉर्ड क्र <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary" placeholder=" ">
                                    <label class="fw-bold">मालमत्ता क्रमांक <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-primary" placeholder=" ">
                                    <label class="fw-bold">मालमत्ता अ.क्र. क्रमांक <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
        
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                    <label class="fw-bold">मालमत्ता धारकाचे नाव <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                    <label class="fw-bold">पत्नीचे नाव</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select border-primary">
                                        <option>--निवडा--</option>
                                    </select>
                                    <label class="fw-bold">भोगवटा धारकाचे नाव</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Search Result Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">माहिती</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center small">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>अ.क्र.</th>
                                        <th>प्र.प्रकार</th>
                                        <th>मत्ता</th>
                                        <th>सांटी</th>
                                        <th>रेंजी</th>
                                        <th>क्षेत्रफळ</th>
                                        <th>भाडे</th>
                                        <th>कर रक्‍त प्रकार</th>
                                        <th>मि इतर माहिती</th>
                                        <th>फरकदार</th>
                                    </tr>
                                    <tr>
                                        <td colspan="10" class="text-center">No records to display.</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
        
                <!-- Lower Table Data -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">मालमत्ता तपशील</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm text-center small">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>अ.क्र.</th>
                                        <th>अनुक्रमांक</th>
                                        <th>वॉर्डचे नाव</th>
                                        <th>मालमत्ता क्रमांक</th>
                                        <th>मालमत्ताधारक नाव</th>
                                        <th>निवडा</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1723</td>
                                        <td>वॉर्ड (अ)</td>
                                        <td>10</td>
                                        <td>मधुकर देऊ कळसिद्धा</td>
                                        <td><a href="#" class="text-primary"><i class="fa fa-edit fa-sm"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>1724</td>
                                        <td>वॉर्ड (अ)</td>
                                        <td>15</td>
                                        <td>दया कृष्णा भाक्त</td>
                                        <td><a href="#" class="text-primary"><i class="fa fa-edit fa-sm"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>1725</td>
                                        <td>वॉर्ड (अ)</td>
                                        <td>10</td>
                                        <td>मधुकर देऊ कळसिद्धा</td>
                                        <td><a href="#" class="text-primary"><i class="fa fa-edit fa-sm"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        
                <!-- Pagination and Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>
                        <button class="btn btn-primary px-4 me-3">
                            <i class="fas fa-save me-2"></i>साठवा
                        </button>
                        <button class="btn btn-outline-danger px-4">
                            <i class="fas fa-times me-2"></i>रद्द करा
                        </button>
                    </div>
                    <div class="text-right">
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                        <small class="text-muted">1080 items in 108 pages</small>
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