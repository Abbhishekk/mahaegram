<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "Dashboard";
?>
<?php include('include/header.php'); ?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = '';
        $subpage = '';
        include('include/sidebar.php');
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="card-box bg-primary text-white p-3 mb-4">
                        <h5>नमुना नं.५ क</h5>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb text-white">
                                <li class="breadcrumb-item"><a href="#" class="text-white">Home</a></li>
                                <li class="breadcrumb-item">नमुना नं.५</li>
                                <li class="breadcrumb-item active text-white" aria-current="page"><strong>नमुना नं.५
                                        क</strong></li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>फंडाचे नाव :</strong></label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label><strong>दिनांक :</strong></label>
                            <input type="date" class="form-control" value="2025-04-11">
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>अनु क्रमांक</th>
                                    <th>जमा केलेल्या दिनांक</th>
                                    <th>पावती क्र.</th>
                                    <th>कोणाकडून मिळाली ते</th>
                                    <th>जमा रकमे संदर्भाची तपशील</th>
                                    <th>रोख रक्कम (रु.)</th>
                                    <th>धनादेश चेक (रु.)</th>
                                    <th>धनादेश / रोख रक्कम जमा केलेल्या दिनांक</th>
                                    <th>धनादेश वटविल्याचा दिनांक</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input type="date" class="form-control"></td>
                                    <td><input type="text" class="form-control"></td>
                                    <td><input type="text" class="form-control"></td>
                                    <td><input type="text" class="form-control"></td>
                                    <td><input type="number" class="form-control" step="0.01"></td>
                                    <td><input type="number" class="form-control" step="0.01"></td>
                                    <td><input type="date" class="form-control"></td>
                                    <td><input type="date" class="form-control"></td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Inputs -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label><strong>सामान्य रोकड :</strong></label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label><strong>वही जमा :</strong></label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label><strong>शिल्लक :</strong></label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary">रिपोर्ट</button>
                            <button class="btn btn-danger">रद्द करणे</button>
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
</body>

</html>