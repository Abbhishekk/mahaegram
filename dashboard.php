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
        
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-md-12 mb-4 ">
                            <div class="card h-100 ">
                                <div class="card-body">
                                    <div class="row align-items-center gap-2 mb-3">
                                        <div class="col-md-3 mr- my-">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">Name
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $_SESSION['user_name'] ?> </div>

                                        </div>
                                        <div class="col-md-3 mr- my-">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">User ID
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $_SESSION['user_id'] ?> </div>

                                        </div>
                                        <div class="col-md-3 mr- my-">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">State
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $_SESSION['state'] ?> </div>

                                        </div>
                                        <div class="col-md-3 mr- my-">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">District Name
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $_SESSION['district_name'] ?> </div>

                                        </div>
                                    </div>
                                    <div class="row align-items-center gap-2">
                                        <div class="col-md-3 mr- my-">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">Panchayat Name
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $_SESSION['panchayat_name'] ?> </div>

                                        </div>
                                        <div class="col-md-3 mr- my-">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">Village Name
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $_SESSION['village_name'] ?> </div>

                                        </div>
                                        <div class="col-md-3 mr- my-">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">LGD Code
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $_SESSION['panchayat_code'] ?> </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">एकूण नोंदी 
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna7data["total_records"] ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">एकूण रक्कम
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna7data["total_amount"] ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                             <div class="text-s font-weight-bold text-uppercase mb-1">नमुना  ७
                                            </div>
                                            <i class="fas fa-users fa-2x text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Annual) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                       <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">मालमत्ता नोंदी 
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($namauna8Data) ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">एकूण रक्कम
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_tax_amount ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                              <div class="text-s font-weight-bold text-uppercase mb-1">नमुना ८
                                            </div>
                                            <i class="fas fa-calendar fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- New User Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                       <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">एकूण नोंदी 
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna9Data["total_records"] ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">एकूण मागणी
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna9Data["total_amount"] ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                              <div class="text-s font-weight-bold text-uppercase mb-1">नमुना ९
                                            </div>
                                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">एकूण नोंदी 
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna10Data["total_records"] ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1">एकूण वसुली 
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $namuna10Data["total_amount"] ?></div>
                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                              <div class="text-s font-weight-bold text-uppercase mb-1">नमुना १०
                                            </div>
                                            <i class="fas fa-comments fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Area Chart -->
                        <div class="col-xl-6 col-lg-6">
                            
                        </div>
                        <!-- Pie Chart -->
                        <div class="col-xl-6 col-lg-6">
                            
                        </div>
                      
                       
                    </div>
                    <!--Row-->
        <div class="row mb-3">
            <div class="col-md-6 mb-4">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                      <a href="dainandinkamkaj.php"  class="alert-link" style="text-decoration:none;"> <div class="card-body ">
                        <div class="alert bg-gradient-primary text-center p-5" role="alert">
                             <h3>दैनंदिन  कामकाज  <br><br>नमुना- ७, ८, ९, १०
                            </h3>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                   <a href=""  class="alert-link" style="text-decoration:none;"> <div class="card-body ">
                        <div class="alert bg-gradient-primary text-center  p-5" role="alert">
                          <h3>डेटा एन्ट्री कामकाज <br><br>नमुने- १ ते  ३३</h3>
                        </div>
                    </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4 col-md-6 mx-auto">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <a href=""  class="alert-link"  style="text-decoration:none;"> <div class="card-body "><div class="card-body ">
                        <div class="alert bg-gradient-primary text-center  p-5" role="alert">
                          <h3>अधिक माहिती</h3>
                        </div>
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
</body>

</html>