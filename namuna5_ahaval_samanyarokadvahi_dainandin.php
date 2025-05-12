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
                        <h1 class="h3 mb-0 text-gray-800">नमुना नं. ५</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना नं. ५</li>
                        </ol>
                    </div>

                    <!-- New Form Section -->
                    <div class="card p-4">
                        <form method="post" action="process.php">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>फंडाचे नाव :</label>
                                    <select class="form-control" name="fund_name">
                                        <option>--निवडा--</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>आर्थिक वर्ष :</label>
                                    <select class="form-control" name="financial_year">
                                        <option>--निवडा--</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>दिनांक :</label>
                                    <input type="date" class="form-control" name="date" value="2025-04-04">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>सुरुवातीची शिल्लक</h5>
                                    <input type="text" class="form-control" name="initial_balance" value="0.00">
                                    <h5>आजची जमा</h5>
                                    <input type="text" class="form-control" name="today_deposit" value="0.00">
                                    <h5>एकूण जमा</h5>
                                    <input type="text" class="form-control" name="total_deposit" value="0.00">
                                </div>
                                <div class="col-md-6">
                                    <h5>आजचा खर्च</h5>
                                    <input type="text" class="form-control" name="today_expense" value="0.00">
                                    <h5>एकूण</h5>
                                    <input type="text" class="form-control" name="total_expense" value="0.00">
                                    <h5>आज शेवटची शिल्लक</h5>
                                    <input type="text" class="form-control" name="final_balance" value="0.00">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5>जमा</h5>
                                    <label>न वटलेल्या चेकची संख्या :</label>
                                    <input type="text" class="form-control" name="uncleared_cheques_deposit"
                                        value="0.00">
                                    <label>रक्कम :</label>
                                    <input type="text" class="form-control" name="cheque_amount_deposit" value="0.00">
                                    <label>वटलेल्या चेकची संख्या :</label>
                                    <input type="text" class="form-control" name="cleared_cheques_deposit" value="0.00">
                                </div>
                                <div class="col-md-6">
                                    <h5>खर्च</h5>
                                    <label>न वटलेल्या चेकची संख्या :</label>
                                    <input type="text" class="form-control" name="uncleared_cheques_expense"
                                        value="0.00">
                                    <label>रक्कम :</label>
                                    <input type="text" class="form-control" name="cheque_amount_expense" value="0.00">
                                    <label>वटलेल्या चेकची संख्या :</label>
                                    <input type="text" class="form-control" name="cleared_cheques_expense" value="0.00">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>बँक भरणा:</label>
                                    <input type="text" class="form-control" name="bank_payment" value="0.00">
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary">रिपोर्ट</button>
                                <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                            </div>
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