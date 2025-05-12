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
                        <h1 class="h3 mb-0 text-gray-800">पुरवणी अंदाजपत्रक</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नमुना क्रमांक 2</li>
                            <li class="breadcrumb-item active" aria-current="page">पुरवणी अंदाजपत्रक</li>
                        </ol>
                    </div>

                    <!-- New Input and Button Section -->
                    <!-- New Input and Button Section -->
                    <div class="card p-4">
                        <form method="post" action="process.php">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="ref_no">अ.क्र *</label>
                                    <input type="text" class="form-control" id="ref_no" name="ref_no" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="date">दिनांक *</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="col-md-4">
                                    <label>प्रकार *</label>
                                    <div>
                                        <input type="radio" name="type" value="जमा" required> जमा
                                        <input type="radio" name="type" value="खर्च"> खर्च
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="financial_year">आर्थिक वर्ष *</label>
                                    <select class="form-control" name="financial_year" id="financial_year" required>
                                        <option value="">Select</option>
                                        <option value="2023-2024">2023-2024</option>
                                        <option value="2024-2025">2024-2025</option>
                                        <option value="2025-2026">2025-2026</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="scheme_name">योजनचे नाव *</label>
                                    <select class="form-control" name="scheme_name" id="scheme_name" required>
                                        <option value="निवडा">निवडा</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="main_account">मुख्य लेखाशिर्ष *</label>
                                    <select class="form-control" name="main_account" id="main_account" required>
                                        <option value="निवडा">निवडा</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="sub_account">उप लेखाशिर्ष *</label>
                                    <input type="text" class="form-control" id="sub_account" name="sub_account"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="budget_ref">अंदाजपत्रकीय रक्कम *</label>
                                    <input type="text" class="form-control" id="budget_ref" name="budget_ref" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="expense_amount">खर्च रक्कम *</label>
                                    <input type="text" class="form-control" id="expense_amount" name="expense_amount"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="title_amount">शिर्षक रक्कम *</label>
                                    <input type="text" class="form-control" id="title_amount" name="title_amount"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="remarks">शेरा</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks">
                                </div>
                            </div>

                            <h5 class="mt-4">पुनर्विनियोजनासाठी उपलब्ध खालील खाती माहिती</h5>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="main_account_realloc">मुख्य लेखाशिर्ष *</label>
                                    <select class="form-control" name="main_account_realloc" id="main_account_realloc"
                                        required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="sub_account_realloc">उप लेखाशिर्ष *</label>
                                    <select class="form-control" name="sub_account_realloc" id="sub_account_realloc"
                                        required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="budget_ref_realloc">अंदाजपत्रकीय रक्कम *</label>
                                    <input type="text" class="form-control" id="budget_ref_realloc"
                                        name="budget_ref_realloc" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="expense_amount_realloc">खर्च रक्कम *</label>
                                    <input type="text" class="form-control" id="expense_amount_realloc"
                                        name="expense_amount_realloc" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="title_amount_realloc">शिर्षक रक्कम *</label>
                                    <input type="text" class="form-control" id="title_amount_realloc"
                                        name="title_amount_realloc" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="resolution_no">ठराव क्रमांक</label>
                                    <input type="text" class="form-control" id="resolution_no" name="resolution_no">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="resolution_date">ठराव दिनांक *</label>
                                    <input type="date" class="form-control" id="resolution_date" name="resolution_date"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="realloc_amount">पुनर्विनियोजन रक्कम *</label>
                                    <input type="text" class="form-control" id="realloc_amount" name="realloc_amount"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="remarks_realloc">शेरा</label>
                                    <input type="text" class="form-control" id="remarks_realloc" name="remarks_realloc">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">साठवणे</button>
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