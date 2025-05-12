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
                    <!-- Header Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="fund_name"><strong>फंडाचे नाव :</strong></label>
                            <select id="fund_name" class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="financial_year"><strong>आर्थिक वर्ष :</strong></label>
                            <select id="financial_year" class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date"><strong>दिनांक :</strong></label>
                            <input type="date" id="date" class="form-control" value="2025-04-11">
                        </div>
                        <div class="col-md-3">
                            <label for="month"><strong>महिना :</strong></label>
                            <select id="month" class="form-control">
                                <option>--निवडा--</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <!-- Middle Section: Two Tables Side-by-Side -->
                    <div class="row">
                        <!-- Left Table -->
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>सुरुवातीची शिल्लक</th>
                                            <th>आजची जमा</th>
                                            <th>एकूण जमा</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>रोख</td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                        </tr>
                                        <tr>
                                            <td>बँक</td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                        </tr>
                                        <tr>
                                            <td>एकूण</td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Right Table -->
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>आजचा खर्च</th>
                                            <th>आज अखेरची शिल्लक</th>
                                            <th>एकूण</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>रोख</td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>बँक</td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>एकूण</td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00"></td>
                                            <td><input type="text" class="form-control" value="0.00" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Section -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label><strong>न वटलेल्या चेकची संख्या :</strong></label>
                            <input type="number" class="form-control" value="0">
                        </div>
                        <div class="col-md-4">
                            <label><strong>रक्कम :</strong></label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary">रिपोर्ट</button>
                            <button class="btn btn-secondary">रद्द करा</button>
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