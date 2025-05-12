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
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid bg-white p-4 border rounded">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div><strong>नमुना क्रमांक 8 / मालमत्ता अ.क्र. बदला</strong></div>
                        <div><a href="#">Home</a> / नमुना क्रमांक 8 / मालमत्ता अ.क्र. बदला</div>
                    </div>

                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label>कालावधी</label>
                            <select class="form-control">
                                <option>2023 - 2027</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>गावाचे नाव</label>
                            <select class="form-control">
                                <option>तलवाडा</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>रस्त्याचे नाव / गल्लीस क्रमांक <span class="text-danger">*</span></label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>वॉर्ड क्र <span class="text-danger">*</span></label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>मालमत्ता क्रमांक <span class="text-danger">*</span></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label>मालमत्ता अ.क्र. क्रमांक <span class="text-danger">*</span></label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label>मालमत्ता धारकाचे नाव <span class="text-danger">*</span></label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>पत्नीचे नाव</label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>भोगवटा धारकाचे नाव</label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Result Table Header -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm text-center">
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

                    <!-- Lower Table Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm text-center">
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
                                    <td><a href="#"><i class="fa fa-edit"></i></a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1724</td>
                                    <td>वॉर्ड (अ)</td>
                                    <td>15</td>
                                    <td>दया कृष्णा भाक्त</td>
                                    <td><a href="#"><i class="fa fa-edit"></i></a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>1725</td>
                                    <td>वॉर्ड (अ)</td>
                                    <td>10</td>
                                    <td>मधुकर देऊ कळसिद्धा</td>
                                    <td><a href="#"><i class="fa fa-edit"></i></a></td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination and Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <button class="btn btn-primary">साठवा</button>
                            <button class="btn btn-secondary">रद्द करा</button>
                        </div>
                        <div class="text-right">
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <!-- Add more pages as needed -->
                                </ul>
                            </nav>
                            <small class="text-muted">1080 items in 108 pages</small>
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