<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "Dashboard";
?>
<?php include('include/header.php'); 
    $namuna7data = $fun->getJamaPavatiDataNamuna7();
    $namuna7data = $namuna7data->fetch_assoc();
    $namauna8Data = $fun->getMalmattaWithPropertiesAccordingToAll();
    $namuna9Data = $fun->getTaxDemandsDataNamuna9();
    $namuna10Data = $fun->getKarvasuliRecordsNamuna10();
    $total_tax_amount = 0;
    foreach ($namauna8Data as $row){
        foreach ($row['properties'] as $property){
            $total_tax = $row['light_tax'] + $row['health_tax'] + $row['water_tax'] + $property['building_value'];
            $total_tax_amount += $total_tax;
        }
    }
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php  ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php');
               ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" style="color: #1a5276 !important;">ग्रामपंचायत डॅशबोर्ड</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">मुख्यपृष्ठ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">डॅशबोर्ड</li>
                        </ol>
                    </div>

                    <!-- User Profile Card -->
                    <div class="card mb-4 border-left-primary shadow">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #1a5276;">
                            <h6 class="m-0 font-weight-bold text-white">वापरकर्ता माहिती</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">नाव</div>
                                        <div class="info-value"><?php echo $_SESSION['user_name'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">वापरकर्ता ID</div>
                                        <div class="info-value"><?php echo $_SESSION['user_id'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">राज्य</div>
                                        <div class="info-value"><?php echo $_SESSION['state'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">जिल्हा</div>
                                        <div class="info-value"><?php echo $_SESSION['district_name'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">पंचायत</div>
                                        <div class="info-value"><?php echo $_SESSION['panchayat_name'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">गाव</div>
                                        <div class="info-value"><?php echo $_SESSION['village_name'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">LGD कोड</div>
                                        <div class="info-value"><?php echo $_SESSION['panchayat_code'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mb-3">
                        <!-- Namuna 7 Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                नमुना ७ (एकूण नोंदी)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna7data["total_records"]?? 0 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                एकूण रक्कम</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹<?php echo $namuna7data["total_amount"]?? 0 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Namuna 8 Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                नमुना ८ (मालमत्ता नोंदी)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($namauna8Data)??0 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-home fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                एकूण कर</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹<?php echo $total_tax_amount?? 0 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Namuna 9 Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                नमुना ९ (एकूण नोंदी)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna9Data["total_records"]??0 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                एकूण मागणी</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹<?php echo $namuna9Data["total_amount"]??0 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Namuna 10 Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                नमुना १० (एकूण नोंदी)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna10Data["total_records"]??0 ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                एकूण वसुली</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹<?php echo $namuna10Data["total_amount"]??0 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Section -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3" style="background-color: #1a5276;">
                                    <h6 class="m-0 font-weight-bold text-white">दैनंदिन कामकाज</h6>
                                </div>
                                <div class="card-body text-center p-0">
                                    <a href="dainandinkamkaj.php" class="btn btn-block btn-primary btn-lg py-4" style="background-color: #2874a6; border-color: #2874a6;">
                                        <i class="fas fa-calendar-day fa-2x mb-2"></i>
                                        <h4>नमुना- ७, ८, ९, १०</h4>
                                        <p class="mb-0">दैनंदिन कार्य प्रविष्टी</p>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3" style="background-color: #1a5276;">
                                    <h6 class="m-0 font-weight-bold text-white">डेटा एन्ट्री</h6>
                                </div>
                                <div class="card-body text-center p-0">
                                    <a href="#" class="btn btn-block btn-primary btn-lg py-4" style="background-color: #2874a6; border-color: #2874a6;">
                                        <i class="fas fa-database fa-2x mb-2"></i>
                                        <h4>नमुने- १ ते ३३</h4>
                                        <p class="mb-0">मूलभूत डेटा प्रविष्टी</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #1a5276;">
                            <h6 class="m-0 font-weight-bold text-white">अधिक माहिती</h6>
                        </div>
                        <div class="card-body text-center p-0">
                            <a href="#" class="btn btn-block btn-primary btn-lg py-4" style="background-color: #2874a6; border-color: #2874a6;">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <h4>अधिकृत माहिती आणि संदर्भ</h4>
                                <p class="mb-0">अधिकृत दस्तऐवज आणि मार्गदर्शक तत्त्वे</p>
                            </a>
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
    
    <style>
        .info-card {
            padding: 10px;
            border-radius: 5px;
            background-color: #f8f9fa;
            height: 100%;
        }
        .info-label {
            font-size: 0.8rem;
            color: #7b8a8b;
            font-weight: bold;
        }
        .info-value {
            font-size: 1rem;
            color: #2c3e50;
            font-weight: bold;
        }
        .card-header {
            border-radius: 5px 5px 0 0 !important;
        }
        .btn-block {
            border-radius: 0 0 5px 5px;
            transition: all 0.3s;
        }
        .btn-block:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .border-left-primary {
            border-left: 4px solid #1a5276 !important;
        }
        .border-left-success {
            border-left: 4px solid #28a745 !important;
        }
        .border-left-info {
            border-left: 4px solid #17a2b8 !important;
        }
        .border-left-warning {
            border-left: 4px solid #ffc107 !important;
        }
        .border-left-danger {
            border-left: 4px solid #dc3545 !important;
        }
    </style>
</body>
</html>