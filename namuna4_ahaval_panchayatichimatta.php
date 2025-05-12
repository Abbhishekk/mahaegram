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
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">पंचायतीच्या मत्ता व दायित्त्वे</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना क्रमांक 4</li>
                            <li class="breadcrumb-item active" aria-current="page">पंचायतीच्या मत्ता व दायित्त्वे</li>
                        </ol>
                    </div>

                    <!-- New Form Section -->
                    <div class="card p-4">
                        <form method="post" action="process.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>१. ग्रामपंचायती कडून देय असलेला थकित रक्कम</h5>
                                    <div class="form-group">
                                        <label>वेतन:</label>
                                        <input type="text" class="form-control" name="salary" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>वेतन व्यतिरिक्त इतर आश्वासन:</label>
                                        <input type="text" class="form-control" name="other_salary_assurance" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>साधनसामग्री:</label>
                                        <input type="text" class="form-control" name="materials" value="0.00">
                                    </div>
                                    <div class="form-group">
                                        <label>बांधकाम:</label>
                                        <input type="text" class="form-control" name="construction" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>इतर:</label>
                                        <input type="text" class="form-control" name="other_expenses" value="0.00">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>ग्रामपंचायतीत येणे असलेला रक्कम</h5>
                                    <div class="form-group">
                                        <label>कर:</label>
                                        <input type="text" class="form-control" name="tax" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>कंत्राट:</label>
                                        <input type="text" class="form-control" name="contract" value="0.00">
                                    </div>
                                    <div class="form-group">
                                        <label>शासनाकडून अनुदान:</label>
                                        <input type="text" class="form-control" name="govt_grant" value="0.00">
                                    </div>
                                    <div class="form-group">
                                        <label>नुकसानभरपाई अनुदान:</label>
                                        <input type="text" class="form-control" name="compensation_grant" value="0.00">
                                    </div>
                                    <div class="form-group">
                                        <label>सहायक अनुदान:</label>
                                        <input type="text" class="form-control" name="auxiliary_grant" value="0.00">
                                    </div>
                                    <div class="form-group">
                                        <label>इतर जमा रक्कम:</label>
                                        <input type="text" class="form-control" name="other_income" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>अशिम तुपसी बाकी:</label>
                                        <input type="text" class="form-control" name="remaining_due" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>पंचायतीची स्थावर मालमता:</label>
                                        <input type="text" class="form-control" name="panchayat_property" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>रस्ता मालमता:</label>
                                        <input type="text" class="form-control" name="road_property" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>जमिनीची मालमता:</label>
                                        <input type="text" class="form-control" name="land_property" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>पाणीपुरवठा योजना मालमता:</label>
                                        <input type="text" class="form-control" name="water_supply_property" value="0">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">रिपोर्ट</button>
                            <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                        </form>
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