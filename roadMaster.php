<?php 
    require_once './include/auth_middleware.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "रस्ते माहिती";
?>
<?php include('include/header.php'); ?>
<?php
    $roads = $fun->getRoad($_SESSION['district_code']);

?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php 
        $page = 'namuna8';
        $subpage = 'wardMaster';
       ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('include/topbar.php'); 
        include('include/sidebar.php');?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">रस्ते माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">पंचायत पोर्टल</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">रस्ते माहिती</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-primary">
                                    <h6 class="m-0 font-weight-bold text-white">रस्ता/गल्ली व्यवस्थापन</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_SESSION['message'])) {
                                        $message = $_SESSION['message'];
                                        $message_type = $_SESSION['message_type'];
                                        echo "<div class='alert alert-$message_type'>$message</div>";
                                        unset($_SESSION['message']);
                                        unset($_SESSION['message_type']);
                                    }
                                    ?>
                                    <form method="post" action="api/road.php">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control border-primary" name="road_name" id="road_name" 
                                                   placeholder="रस्ते / गल्लीचे नाव" required>
                                            <label for="road_name">गल्ली व अंतर्गत रस्ते <span class="text-danger">*</span></label>
                                            <input type="number" value="" class="form-control d-none" name="update" id="update">
                                        </div>
                    
                                        <div class="d-flex gap-3">
                                            <button type="submit" name="add" class="btn btn-primary px-4">
                                                <i class="fas fa-save me-2"></i>साठवणे
                                            </button>
                                            <button type="reset" class="btn btn-outline-danger px-4">
                                                <i class="fas fa-times me-2"></i>रद्द करणे
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-header py-3 bg-primary">
                                    <h6 class="m-0 font-weight-bold text-white">रस्ते/गल्ली यादी</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>गल्ली व अंतर्गत रस्ते</th>
                                                <th>बदल</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(mysqli_num_rows($roads) > 0){
                                                $i = 1;
                                                while($road = mysqli_fetch_assoc($roads)){
                                            ?>
                                            <tr>
                                                <td><a href="#"><?php echo $i; ?></a></td>
                                                <td><?php echo $road['road_name']; ?></td>
                                                <td>
                                                    <a href="#" class="text-primary" 
                                                       onclick="filldata('<?php echo $road['id']; ?>', '<?php echo $road['road_name']; ?>')">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                                }
                                            }else{
                                                echo "<tr><td colspan='3' class='text-center'>No data found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer"></div>
                            </div>
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
    <script>
    function filldata(id, road_name) {
        document.getElementById('update').value = id;
        document.getElementById('road_name').value = road_name;
    }
    </script>
</body>

</html>