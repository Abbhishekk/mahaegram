<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to dashboard
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = "Panchayat Portal Login";
?>
<?php include('include/header.php'); ?>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="login-form">
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

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <form class="user" method="post" action="api/login.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="user_id" name="user_id"
                                                aria-describedby="emailHelp" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password">
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>

                                        </div>
                                        <hr>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="register.php">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>