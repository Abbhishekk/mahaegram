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
                    <!-- Page Header -->
                    <div class="row mb-3">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><strong>महिन्यानुसार जमा ताळमेळ पत्रक</strong></h5>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-white p-0 m-0">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                                    <li class="breadcrumb-item">महिन्यानुसार जमा ताळमेळ पत्रक</li>
                                    <li class="breadcrumb-item active" aria-current="page"><strong>महिन्यानुसार जमा
                                            ताळमेळ पत्रक</strong></li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label><strong>फंडाचे नाव :</strong></label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                                <!-- Dynamic fund options -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><strong>आर्थिक वर्ष :</strong></label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                                <!-- Dynamic financial year options -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><strong>महिना :</strong></label>
                            <select class="form-control">
                                <option>एप्रिल</option>
                                <!-- Add other months -->
                            </select>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>अ क्रं</th>
                                    <th>महिना अखेर शिल्लक</th>
                                    <th>पासबुक अखेर शिल्लक</th>
                                    <th>दैनंदिन व पासबुक मध्ये फरक</th>
                                    <th>चेक क्रमांक</th>
                                    <th>चेक दिल्याची दिनांक</th>
                                    <th>चेक दिल्याची रक्कम</th>
                                    <th>चेक वटल्याची दिनांक</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8">No records to display.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6><strong>जमा</strong></h6>
                        </div>
                        <div class="col-md-2">
                            <label>न वटलेल्या चेकची संख्या :</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label>रक्कम:</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label>वटलेला चेकची संख्या :</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label>रक्कम:</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>

                        <div class="col-12 mt-3">
                            <h6><strong>खर्च</strong></h6>
                        </div>
                        <div class="col-md-2">
                            <label>न वटलेल्या चेकची संख्या :</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label>रक्कम:</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label>वटलेला चेकची संख्या :</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-2">
                            <label>रक्कम:</label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row mb-5">
                        <div class="col text-center">
                            <button class="btn btn-primary px-4">रिपोर्ट</button>
                            <button class="btn btn-secondary px-4">रद्द करणे</button>
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