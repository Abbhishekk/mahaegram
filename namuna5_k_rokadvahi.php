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
                            <h5 class="mb-0"><strong>नमुना नं.५ क</strong></h5>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-white p-0 m-0">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                                    <li class="breadcrumb-item">नमुना नं.५ क</li>
                                    <li class="breadcrumb-item active" aria-current="page"><strong>नमुना नं.५ क</strong>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>फंडाचे नाव :</strong></label>
                            <select class="form-control">
                                <option>--निवडा--</option>
                                <!-- Add dynamic options here -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label><strong>दिनांक :</strong></label>
                            <input type="date" class="form-control" value="2025-04-11">
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>अ क्रं</th>
                                    <th>दिनांक</th>
                                    <th>पावती क्रमांक</th>
                                    <th>कर देणाऱ्याचे नाव</th>
                                    <th>घरपुऱी मागितले</th>
                                    <th>घरपुऱी चाचू</th>
                                    <th>सूत्त</th>
                                    <th>वीज कर मागीत</th>
                                    <th>वीज कर चाचू</th>
                                    <th>आरोग्य कर मागीत</th>
                                    <th>आरोग्य कर चाचू</th>
                                    <th>सामान्य पाणीपिऊ मागीत</th>
                                    <th>सामान्य पाणीपिऊ चाचू</th>
                                    <th>दंड</th>
                                    <th>नोटिस फी</th>
                                    <th>एकूण रक्कम</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="16">No records to display.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Section -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label><strong>सामान्य रोकड</strong></label>
                            <input type="text" class="form-control" value="000">
                        </div>
                        <div class="col-md-4">
                            <label><strong>वही जमा</strong></label>
                            <input type="text" class="form-control" value="0.00">
                        </div>
                        <div class="col-md-4">
                            <label><strong>शिल्लक</strong></label>
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