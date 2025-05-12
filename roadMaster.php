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
                        <h1 class="h3 mb-0 text-gray-800">रस्ते माहिती</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">माहईग्राम</a></li>
                            <li class="breadcrumb-item active" aria-current="page">नामुना क्रमांक 8</li>
                            <li class="breadcrumb-item active" aria-current="page">मास्टर्स</li>
                            <li class="breadcrumb-item active" aria-current="page">रस्ते माहिती</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <?php

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];

    echo "<div class='alert alert-$message_type'>$message</div>";

    // Unset the message so it doesn't persist after refresh
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
                                <div class="card-body">
                                    <form method="post" action="api/road.php">
                                        <div class="form-group">
                                            <label for="ward_name">गल्ली व अंतर्गत रस्ते <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="road_name" id="road_name"
                                                aria-describedby="emailHelp" placeholder="रस्ते / गल्लीचे नाव" required>

                                            <input type="number" value="" class="form-control d-none" name="update"
                                                id="update" aria-describedby="emailHelp" placeholder="वॉर्डचे नाव">
                                        </div>


                                        <button type="submit" name="add" class="btn btn-primary">साठवणे</button>
                                        <button type="reset" class="btn btn-secondary">रद्द करणे</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">

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
                                                <td><a href="#" class=""
                                                        onclick="filldata('<?php echo $road['id']; ?>', '<?php echo $road['road_name']; ?>')"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-pencil-square"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                        </svg></a></td>
                                            </tr>
                                            <?php
                                                    $i++;
                                                    }
                                                }else{
                                                    echo "<tr><td colspan='4'>No data found</td></tr>";
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