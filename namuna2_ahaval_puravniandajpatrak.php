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
                    <div class="card p-4">
                        <form method="post" action="process.php">
                            <div class="form-group">
                                <label for="financial_year">आर्थिक वर्ष <span class="text-danger">*</span></label>
                                <select class="form-control" name="financial_year" id="financial_year" required>
                                    <option value="">Select</option>
                                    <option value="2023-2024">2023-2024</option>
                                    <option value="2024-2025">2024-2025</option>
                                    <option value="2025-2026">2025-2026</option>
                                </select>
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