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


                <div class="container-fluid mt-3">

                    <!-- Header with Breadcrumb -->


                    <!-- Selection Fields -->
                    <div class="card-box">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>फंडाचे नाव :</label>
                                <select class="form-control">
                                    <option>--निवडा--</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>आर्थिक वर्ष :</label>
                                <select class="form-control">
                                    <option>--निवडा--</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>दिनांक :</label>
                                <input type="date" class="form-control" value="2025-04-11">
                            </div>
                        </div>
                    </div>

                    <!-- Dual Table Section -->
                    <div class="card-box">
                        <div class="row">
                            <!-- Left Table -->
                            <div class="col-md-6">
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
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>बँक</td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>एकूण</td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Right Table -->
                            <div class="col-md-6">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>आजचा खर्च</th>
                                            <th>एकूण</th>
                                            <th>आज अखेरची शिल्लक</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>रोख</td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>बँक</td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>एकूण</td>
                                            <td><input class="form-control" value="0.00"></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                            <td><input class="form-control" value="0.00" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Cheque Section -->
                    <div class="card-box">
                        <h6><strong>जमा</strong></h6>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>न वटलेल्या चेकची संख्या :</label>
                                <input class="form-control" value="0.00">
                            </div>
                            <div class="form-group col-md-3">
                                <label>रक्कम :</label>
                                <input class="form-control" value="0.00">
                            </div>
                            <div class="form-group col-md-3">
                                <label>वटलेल्या चेकची संख्या :</label>
                                <input class="form-control" value="0.00">
                            </div>
                            <div class="form-group col-md-3">
                                <label>रक्कम :</label>
                                <input class="form-control" value="0.00">
                            </div>
                        </div>

                        <h6><strong>खर्च</strong></h6>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>न वटलेल्या चेकची संख्या :</label>
                                <input class="form-control" value="0.00">
                            </div>
                            <div class="form-group col-md-3">
                                <label>रक्कम :</label>
                                <input class="form-control" value="0.00">
                            </div>
                            <div class="form-group col-md-3">
                                <label>वटलेल्या चेकची संख्या :</label>
                                <input class="form-control" value="0.00">
                            </div>
                            <div class="form-group col-md-3">
                                <label>बँक भरणा:</label>
                                <input class="form-control" value="0.00">
                            </div>
                        </div>

                        <div class="text-center">
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