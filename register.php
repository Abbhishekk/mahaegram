<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$title = "Mahaegram Register";
?>
<?php include('include/header.php'); ?>
<?php
   $states = $fun->getUniqueStates();
?>

<body class="bg-gradient-login">
    <!-- Register Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    $user_id = $_SESSION['user_id'];
    echo "<div class='alert alert-$message_type'>$message</div>";
    echo "<div class='alert alert-$message_type'>User Id: $user_id</div>";

    // Unset the message so it doesn't persist after refresh
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
    unset($_SESSION['user_id']);
}
?>
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                    </div>
                                    <form method="post" action="api/register_user.php" class="user">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile"
                                                placeholder="Enter Mobile Number" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="exampleInputEmail" name="email"
                                                aria-describedby="emailHelp" required placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" class="form-control" id="designation" name="designation"
                                                aria-describedby="emailHelp" required placeholder="Enter Designation" />
                                        </div>
                                        <div class="form-group">
                                            <label for="state">Select State</label>
                                            <select class="select2-single-placeholder form-control" required
                                                name="state" id="state">
                                                <option value="">Select State</option>
                                                <?php
                                                if ($states->num_rows > 0) {
                                                    while ($row = $states->fetch_assoc()) {
                                                        echo '<option value="' . htmlspecialchars($row['state']) . '">' . htmlspecialchars($row['state']) . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">No States Found</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="district">Select District</label>
                                            <select class="select2-single-placeholder form-control" required
                                                name="district" id="district">
                                                <option value="">Select District</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="district">Select Panchayat</label>
                                            <select class="select2-single-placeholder form-control" required
                                                name="panchayat" id="panchayat">
                                                <option value="">Select Panchayat</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="village">Select Village</label>
                                            <select class="select2-single-placeholder form-control" required
                                                name="village" id="village">
                                                <option value="">Select Village</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" required name="password"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label>Repeat Password</label>
                                            <input type="password" class="form-control" required name="password_repeat"
                                                id="exampleInputPasswordRepeat" placeholder="Repeat Password">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>
                                        <hr>

                                    </form>
                                    <hr>

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
    <!-- Register Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select2-single').select2();

        // Select2 Single  with Placeholder
        $('.select2-single-placeholder').select2({
            placeholder: "Select a Province",
            allowClear: true
        });

        // Select2 Multiple
        $('.select2-multiple').select2();
        $('#state').on('change', function() {
            var state = $(this).val();
            $.ajax({
                url: 'api/get_district.php',
                type: 'POST',
                data: {
                    state: state
                },
                success: function(data) {
                    $('#district').html(data);
                    $('#village').html('<option value="">Select Village</option>');
                }
            });
        });

        $('#district').on('change', function() {
            var district = $(this).val();
            $.ajax({
                url: 'api/get_panchayat.php',
                type: 'POST',
                data: {
                    district: district
                },
                success: function(data) {
                    $('#panchayat').html(data);
                    $('#village').html('<option value="">Select Village</option>');
                }
            });
        });

        $('#panchayat').on('change', function() {
            var district = $(this).val();
            $.ajax({
                url: 'api/get_villages.php',
                type: 'POST',
                data: {
                    district: district
                },
                success: function(data) {
                    $('#village').html(data);
                }
            });
        });
    });
    </script>

</body>

</html>