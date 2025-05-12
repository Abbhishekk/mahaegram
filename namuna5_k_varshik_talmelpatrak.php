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
                            <h5 class="mb-0"><strong>वार्षिक ताळमेळ पत्रक</strong></h5>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-white p-0 m-0">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                                    <li class="breadcrumb-item">वार्षिक ताळमेळ पत्रक</li>
                                    <li class="breadcrumb-item active" aria-current="page"><strong>वार्षिक ताळमेळ
                                            पत्रक</strong></li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label><strong>फंडाचे नाव :</strong></label>
                            <select class="form-control">
                                <option selected>ग्रामनिधी</option>
                                <!-- Other fund options -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><strong>आर्थिक वर्ष :</strong></label>
                            <select class="form-control">
                                <option selected>2024 - 2025</option>
                                <!-- Other financial year options -->
                            </select>
                        </div>
                    </div>

                    <!-- Data Table Section -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>अ क्रं</th>
                                    <th>महिना</th>
                                    <th>महिना अखेर शिल्लक</th>
                                    <th>पासबुक अखेर शिल्लक</th>
                                    <th>दैनंदिन व पासबुक मधील फरक</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>एप्रिल</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>मे</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>जून</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>जुलै</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>ऑगस्ट</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>सप्टेंबर</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>ऑक्टोबर</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>नोव्हेंबर</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>डिसेंबर</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>जानेवारी</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="row mb-4">
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